<div class="max-w-[60rem]" x-data="{ orientation: 'vertical' }">
    @include('livewire.cashier.components.payslip')
    <div class="mt-4">
        <div class="p-4">
            <h4 class="font-semibold">Orientation</h4>
            <label class="flex items-center gap-2" for="vertical">
                <input x-model="orientation" value="vertical" type="radio" name="orientation" id="vertical">
                Vertical
            </label>
            <label class="flex items-center gap-2" for="horizontal">
                <input x-model="orientation" value="horizontal" type="radio" name="orientation" id="horizontal">
                Horizontal
            </label>
        </div>
        <div>
            <x-filament-support::button icon="heroicon-o-printer" @click="printOut($refs.print.outerHTML, 'RELEASE PAYSLIP')">Print</x-filament-support::button>
            <x-filament-support::button href="{{ route('cashier.releases.dividends', ['release' => $dividend->release]) }}" icon="heroicon-o-arrow-left" color="success" tag="a">RELEASE ANOTHER</x-filament-support::button>
        </div>
    </div>

</div>
