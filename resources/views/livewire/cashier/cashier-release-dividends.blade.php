<div class="mt-10">
    <div class="flex justify-between">
        <h1 class="text-xl font-bold text-custom-blue">Release Dividends</h1>
        <x-filament::button href="{{ route('cashier.cash-monitoring-report', ['release' => $release]) }}" tag="a" outlined>Cash Monitoring Report</x-filament::button>
    </div>
    <div class="mt-2">
        {{ $this->table }}
    </div>
</div>
