const express = require('express');
const cors = require('cors');
const QRCode = require('qrcode');
const pino = require('pino');
const path = require('path');
const fs = require('fs');
const {
    default: makeWASocket,
    useMultiFileAuthState,
    DisconnectReason,
    fetchLatestBaileysVersion,
} = require('@whiskeysockets/baileys');

const app = express();
app.use(cors());
app.use(express.json());

const PORT = process.env.PORT || 3000;
const AUTH_DIR = path.join(__dirname, 'auth_info_baileys');

if (typeof(PhusionPassenger) !== 'undefined') {
    PhusionPassenger.configure({ autoInstall: false });
}

let sock = null;
let currentQr = null;
let connectionStatus = 'disconnected';
let connectedPhone = null;

async function connectToWhatsApp() {
    connectionStatus = 'connecting';
    currentQr = null;

    const { state, saveCreds } = await useMultiFileAuthState(AUTH_DIR);
    const { version } = await fetchLatestBaileysVersion();

    sock = makeWASocket({
        version,
        logger: pino({ level: 'silent' }),
        auth: state,
        browser: ['DrDeepak-ERP', 'Chrome', '1.0.0'],
    });

    sock.ev.on('creds.update', saveCreds);

    sock.ev.on('connection.update', async (update) => {
        const { connection, lastDisconnect, qr } = update;

        if (qr) {
            connectionStatus = 'qr_required';
            try {
                currentQr = await QRCode.toDataURL(qr);
            } catch (err) {
                console.error('Failed to generate QR DataURL:', err);
            }
        }

        if (connection === 'open') {
            connectionStatus = 'connected';
            currentQr = null;
            const jid = sock.user ? sock.user.id : '';
            connectedPhone = jid.split(':')[0] || jid.split('@')[0];
            console.log('✅ WhatsApp API Connected Successfully as:', connectedPhone);
        }

        if (connection === 'close') {
            const shouldReconnect = (lastDisconnect?.error)?.output?.statusCode !== DisconnectReason.loggedOut;
            console.log('⚠️ WhatsApp connection closed. Reconnecting:', shouldReconnect);
            connectionStatus = 'disconnected';
            connectedPhone = null;
            currentQr = null;

            if (shouldReconnect) {
                setTimeout(connectToWhatsApp, 3000);
            }
        }
    });
}

// REST Endpoints
app.get('/status', (req, res) => {
    res.json({
        status: connectionStatus,
        qr: currentQr,
        phone: connectedPhone,
    });
});

app.post('/send-message', async (req, res) => {
    try {
        const { phone, message } = req.body;

        if (!phone || !message) {
            return res.status(400).json({ success: false, error: 'Phone and message are required.' });
        }

        if (connectionStatus !== 'connected' || !sock) {
            return res.status(503).json({ success: false, error: 'WhatsApp API service is not connected. Please scan QR Code in Settings.' });
        }

        let cleanPhone = phone.replace(/[^0-9]/g, '');
        if (cleanPhone.startsWith('0')) {
            cleanPhone = '92' + cleanPhone.substring(1);
        }

        // Check if number exists on WhatsApp using Baileys onWhatsApp
        console.log(`🔍 Checking WhatsApp registration for number: +${cleanPhone}`);
        const results = await sock.onWhatsApp(cleanPhone);
        const onWa = Array.isArray(results) && results.length > 0 ? results[0] : null;

        if (!onWa || !onWa.exists) {
            console.log(`❌ Number +${cleanPhone} is NOT registered on WhatsApp.`);
            return res.status(400).json({
                success: false,
                error: `Phone number +${cleanPhone} is NOT registered on WhatsApp!`
            });
        }

        const jid = onWa.jid;
        console.log(`📤 Sending WhatsApp message to JID: ${jid}...`);

        const result = await sock.sendMessage(jid, { text: message });

        console.log(`✅ WhatsApp Message Sent Successfully! ID: ${result.key.id}`);

        return res.json({
            success: true,
            messageId: result.key.id,
            to: cleanPhone,
            jid: jid,
        });
    } catch (err) {
        console.error('Error sending WhatsApp message:', err);
        return res.status(500).json({ success: false, error: err.message });
    }
});

app.post('/logout', async (req, res) => {
    try {
        if (sock) {
            await sock.logout();
        }
        if (fs.existsSync(AUTH_DIR)) {
            fs.rmSync(AUTH_DIR, { recursive: true, force: true });
        }
        connectionStatus = 'disconnected';
        connectedPhone = null;
        currentQr = null;
        setTimeout(connectToWhatsApp, 1000);

        return res.json({ success: true, message: 'Logged out successfully.' });
    } catch (err) {
        return res.status(500).json({ success: false, error: err.message });
    }
});

// Start WhatsApp socket & Express server
if (typeof(PhusionPassenger) !== 'undefined') {
    app.listen('passenger', () => {
        console.log('🚀 WhatsApp API running under Phusion Passenger');
        connectToWhatsApp();
    });
} else {
    app.listen(PORT, () => {
        console.log(`🚀 WhatsApp Node.js API Service running on http://127.0.0.1:${PORT}`);
        connectToWhatsApp();
    });
}
