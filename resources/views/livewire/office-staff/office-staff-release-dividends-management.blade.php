<div>
    <x-title>Manage Release Dividends</x-title>
    <div class="p-4 bg-white rounded-md shadow">
        <h4>Release Name: {{ $release->name }}</h4>
        <h5>Total Amount: <strong>{{ Akaunting\Money\Money::PHP($release->total_amount, true) }}</strong></h5>
        <h5>Release Date: {{ $release->created_at->format('M d, Y') }}</h5>
        <h5>Dividends Net Amount: <strong>{{ Akaunting\Money\Money::PHP($dividends_net_amount, true) }}</strong>
        </h5>
    </div>
    <div class="mt-4">
        <div class="p-4 bg-white rounded-md shadow">
            <div class="flex gap-4">
                <div class='flex flex-col items-start flex-1'>
                    <div class="w-full">
                        {{ $this->form }}
                    </div>
                </div>
                <div class="flex-1 flex justify-center flex-col items-stretch">
                    <div class="grid grid-cols-2 gap-2">
                        <x-forms::button wire:click="generateDividends" wire:target="generateDividends">
                            Regenerate Pending Dividends
                        </x-forms::button>
                        <x-forms::button wire:click="clearDividends" wire:target="clearDividends">
                            Clear Pending Dividends
                        </x-forms::button>
                        <x-forms::button wire:click="clearRestrictions" wire:target="clearRestrictions">
                            Clear Dividend Restrictions
                        </x-forms::button>
                        <x-forms::button wire:click="clearDeductions" wire:target="clearDeductions">
                            Clear Dividend Deductions
                        </x-forms::button>
                    </div>
                    <div class="mt-2">
                        <style>
                            .filament-modal {
                                width: 100%;
                            }
                        </style>
                        @if (round($release->total_amount) == round($dividends_net_amount))
                            <x-filament::modal class="w-full">
                                <x-slot name="trigger">
                                    <x-forms::button class="!w-full whitespace-nowrap bg-custom-green hover:!bg-green-hover focus:!bg-green-hover focus:!ring-0 focus:!ring-offset-0" @click="isOpen = true">
                                        Finalize and Disburse Dividends
                                    </x-forms::button>
                                </x-slot>

                                <strong>Are you sure you want to disburse the selected dividends?</strong>

                                <x-slot name="actions">
                                    <div class="flex justify-end">
                                        <x-forms::button class="bg-custom-green hover:!bg-green-hover focus:!bg-green-hover focus:!ring-0 focus:!ring-offset-0" wire:click="finalize" wire:target="finalize">
                                            Submit</x-forms::button>
                                    </div>
                                </x-slot>
                            </x-filament::modal>
                        @endif
                    </div>
                </div>
            </div>

            <div class="flex mt-8 flex-col">
                {{ $this->table }}
            </div>
        </div>
    </div>
</div>
