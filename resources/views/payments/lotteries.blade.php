<x-app-layout>
    <!-- Payments To Lotteries (Inside Payments section) -->
    <x-lottery-voucher 
        :records="$payments" 
        :currentRecord="$currentPayment ?? null" 
        title="Payments To Lotteries" 
        storeRoute="payments-to-lotteries.store" 
        deleteRouteBase="payments-to-lotteries.destroy" 
        exitRoute="payments.index" 
    />
</x-app-layout>
