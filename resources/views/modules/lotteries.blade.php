<x-app-layout>
    <!-- Main / Outside Lotteries section (Identical 1:1 Design to Payments Lotteries) -->
    <x-lottery-voucher 
        :records="$lotteries" 
        :currentRecord="$currentLottery ?? null" 
        title="Payments To Lotteries" 
        storeRoute="lotteries.store" 
        deleteRouteBase="lotteries.destroy" 
        exitRoute="dashboard" 
    />
</x-app-layout>
