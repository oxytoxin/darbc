<div x-data>
    <div class="mt-10">
        <h1 class="text-xl font-bold text-custom-blue">Daily Cash</h1>
        <div class="bg-white p-4 rounded">
            <h3 class="font-semibold">Date Today: {{ today()->format('M d, Y') }}</h3>
            <div class="max-w-sm">
                <div class="space-y-2">
                    <div class="flex gap-16 items-center">
                        <p class="flex-1 text-sm">CASH, BEGINNING</p>
                        <p @class(['font-bold flex-1 text-right border-b-2 border-black pr-2'])>{{ $beginning_cash }}</p>
                    </div>
                    <div class="flex gap-16 items-center">
                        <p class="flex-1 text-sm">CASH, END</p>
                        <p @class(['font-bold flex-1 text-right border-b-2 border-black pr-2'])>{{ $actual_end_cash }}</p>
                    </div>
                    <div class="flex gap-16 items-center">
                        <p class="flex-1 text-sm font-bold">CASH RELEASED</p>
                        <p @class(['font-bold flex-1 text-right border-b-2 border-black pr-2'])>{{ $cash_released }}</p>
                    </div>
                </div>
                <div class="space-y-4">
                    <div>
                        <p>TOTAL RELEASED</p>
                        <div class="pl-8">
                            <div class="flex gap-8 items-center">
                                <p class="flex-1 text-sm">COUNT</p>
                                <p @class(['font-bold flex-1 border-b-2 border-black text-right pr-2'])>{{ $release_count }}</p>
                            </div>
                            <div class="flex gap-8 items-center">
                                <p class="flex-1 text-sm">AMOUNT</p>
                                <p @class(['font-bold flex-1 border-b-2 border-black text-right pr-2'])>{{ $release_amount }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="flex gap-16 items-center">
                        <p class="flex-1 text-sm">CASH OVER (SHORT)</p>
                        <p @class([
                            'font-bold flex-1 text-right pr-2 border-b-2 border-black',
                            'text-red-600' => $cash_over_short < 0,
                            'text-green-600' => $cash_over_short >= 0,
                        ])>{{ $cash_over_short }}</p>
                    </div>
                </div>
            </div>

            <div class="flex justify-end gap-2">
                <x-filament::button @click="printOut($refs.cashendform.innerHTML, 'Cash End Form')" icon="heroicon-o-printer">Print</x-filament::button>
                @if ($this->daily_cash_start || $this->daily_cash_end)
                    <x-filament::button wire:click="saveDailyCash" wire:target="saveDailyCash" icon="heroicon-o-check-circle">Save Daily Cash</x-filament::button>
                @endif
            </div>
        </div>
        <div class="mt-2 flex items-start gap-2">
            <div>
                <label class="font-semibold" for="lane">
                    Lane <input class="@error('lane') border border-red-600 @enderror rounded text-sm text-right" id="lane" type="text" @if ($this->daily_cash_start || $this->daily_cash_end) disabled @endif wire:model.defer="lane" placeholder="Enter Lane number">
                </label>
                @error('lane')
                    <p class="text-red-600 font-semibold text-sm">{{ $message }}</p>
                @enderror
            </div>
            @if (!$this->daily_cash_start)
                <x-filament::button wire:click="createDailyCashStart" wire:target="createDailyCashStart" icon="heroicon-o-bookmark">Create Cash Beginning</x-filament::button>
            @endif
            @if (!$this->daily_cash_end && $this->daily_cash_start)
                <x-filament::button wire:click="createDailyCashEnd" wire:target="createDailyCashEnd" icon="heroicon-o-flag">Create Cash End</x-filament::button>
            @endif
        </div>
        <div class="w-full grid grid-cols-2 gap-4 my-8">
            <div>
                @if ($this->daily_cash_start)
                    {{ $this->daily_cash_start_form }}
                @endif
            </div>
            <div>
                @if ($this->daily_cash_end)
                    {{ $this->daily_cash_end_form }}
                @endif
            </div>
        </div>
    </div>
    <div class="sr-only" x-ref="cashendform">
        @include('forms.views.cash-end-form')
    </div>
</div>
