<div>
    <div class="mt-10">
        <h1 class="text-xl font-bold text-custom-blue">Manage Release Dividends</h1>
        <div class="p-4 mt-4 bg-white rounded-md shadow">
            <h4>Release Name: {{ $release->name }}</h4>
            <h5>Total Amount: <strong>{{ Akaunting\Money\Money::PHP($release->total_amount, true) }}</strong></h5>
            <h5>Release Date: {{ $release->created_at->format('M d, Y') }}</h5>
            <h5>Dividends Net Amount: <strong>{{ Akaunting\Money\Money::PHP($dividends_net_amount, true) }}</strong>
            </h5>
        </div>
        <div class="mt-4">
            <div class="p-4 bg-white rounded-md shadow">
                <div class="flex">
                    <div class='flex flex-col items-start flex-1'>
                        <div class="w-full">
                            {{ $this->form }}
                        </div>
                    </div>
                    <div class="flex-1 p-6">
                        <div class="grid grid-cols-2 gap-2">
                            <x-forms::button wire:click="generateDividends" wire:target="generateDividends">Regenerate
                                Pending Dividends</x-forms::button>
                            <x-forms::button wire:click="clearDividends" wire:target="clearDividends">Clear Pending
                                Dividends</x-forms::button>
                            <x-forms::button wire:click="clearRestrictions" wire:target="clearRestrictions">Clear
                                Dividend Restrictions</x-forms::button>
                            <x-forms::button wire:click="clearDeductions" wire:target="clearDeductions">Clear Dividend
                                Deductions</x-forms::button>
                        </div>
                        <div class="mt-2">
                            @if ($release->total_amount == $dividends_net_amount)
                            <x-filament::modal>
                                <x-slot name="trigger">
                                    <x-forms::button @click="isOpen = true"
                                        class="!px-44 whitespace-nowrap bg-custom-green hover:!bg-green-hover focus:!bg-green-hover focus:!ring-0 focus:!ring-offset-0">
                                        Finalize and Disburse Dividends
                                    </x-forms::button>
                                </x-slot>

                                <strong>Are you sure you want to disburse the selected dividends?</strong>

                                <x-slot name="actions">
                                    <div class="flex justify-end">
                                        <x-forms::button wire:click="finalize" wire:target="finalize"
                                            class="bg-custom-green hover:!bg-green-hover focus:!bg-green-hover focus:!ring-0 focus:!ring-offset-0">
                                            Submit</x-forms::button>
                                    </div>
                                </x-slot>
                            </x-filament::modal>
                            @endif
                        </div>
                    </div>
                </div>

                <div class='mt-4'>
                    <div class='flex items-center w-full space-x-3'>
                        <form action="#" x-data="{ files: null }">
                            <label
                                class="border p-2.5 w-full block rounded-md cursor-pointer my-2 bg-custom-green text-white"
                                for="excelfile">
                                <div class='flex items-center space-x-2'>
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24">
                                        <path class="fill-current"
                                            d="M2.859 2.877l12.57-1.795a.5.5 0 0 1 .571.495v20.846a.5.5 0 0 1-.57.495L2.858 21.123a1 1 0 0 1-.859-.99V3.867a1 1 0 0 1 .859-.99zM4 4.735v14.53l10 1.429V3.306L4 4.735zM17 19h3V5h-3V3h4a1 1 0 0 1 1 1v16a1 1 0 0 1-1 1h-4v-2zm-6.8-7l2.8 4h-2.4L9 13.714 7.4 16H5l2.8-4L5 8h2.4L9 10.286 10.6 8H13l-2.8 4z" />
                                    </svg>
                                    <h1>Import from Excel</h1>
                                </div>
                                <input type="file" class="sr-only" id="excelfile"
                                    x-on:change="files = Object.values($event.target.files)">
                            </label>
                        </form>
                    </div>
                </div>
                <div class="flex flex-col">
                    {{ $this->table }}
                </div>
            </div>
        </div>
    </div>
</div>
