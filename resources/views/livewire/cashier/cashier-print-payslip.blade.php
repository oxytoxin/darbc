<div class="max-w-[60rem]" x-data>
    @include('livewire.cashier.components.payslip')
    <div class="mt-4">
        <x-filament-support::button icon="heroicon-o-printer" @click="printOut($refs.print.outerHTML, 'RELEASE PAYSLIP')">Print</x-filament-support::button>
        <x-filament-support::button href="{{ route('cashier.releases.dividends', ['release' => $dividend->release]) }}" icon="heroicon-o-arrow-left" color="success" tag="a">RELEASE ANOTHER</x-filament-support::button>
    </div>

</div>
