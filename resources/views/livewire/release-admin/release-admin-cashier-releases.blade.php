<div>
    <h1 class="flex items-center justify-between mt-10 mb-2 text-xl font-bold text-custom-blue">
        <p>Cashier Releases</p>
    </h1>
    <div class="flex gap-2 mb-4 font-bold text-custom-blue" x-cloak x-data>
        <div>
            <p>Release</p>
            <select class="text-sm rounded" id="releases" wire:model.live="release_id">
                @foreach ($releases as $release)
                    <option value="{{ $release->id }}">{{ $release->name }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <p>From</p>
            <input class="text-sm rounded" type="datetime-local" wire:model="from">
        </div>
        <div>
            <p>To</p>
            <input class="text-sm rounded" type="datetime-local" wire:model="to">
        </div>
    </div>
    <div class="relative">
        <div class="absolute inset-0 z-30 bg-white" wire:loading.delay wire:target="to, from, release_id">
            <div class="grid w-full h-full place-items-center">
                <p class="animate-bounce">Loading data...</p>
            </div>
        </div>
        @if ($selected_release)
            <div class="flex flex-col justify-between p-3 mb-4 bg-white border rounded-md">
                <div class="flex items-center justify-between">
                    <p class="font-medium text-gray-500">{{ $selected_release->name }} release statistics</p>
                    <section class="flex items-center space-x-1 text-custom-blue">
                        <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5m-9-6h.008v.008H12v-.008zM12 15h.008v.008H12V15zm0 2.25h.008v.008H12v-.008zM9.75 15h.008v.008H9.75V15zm0 2.25h.008v.008H9.75v-.008zM7.5 15h.008v.008H7.5V15zm0 2.25h.008v.008H7.5v-.008zm6.75-4.5h.008v.008h-.008v-.008zm0 2.25h.008v.008h-.008V15zm0 2.25h.008v.008h-.008v-.008zm2.25-4.5h.008v.008H16.5v-.008zm0 2.25h.008v.008H16.5V15z" />
                        </svg>
                        <h1 class="text-sm font-medium">{{ date_format(date_create($from), 'h:i A M d, Y') }} - {{ date_format(date_create($to), 'h:i A M d, Y') }}</h1>
                    </section>
                </div>
                <div class="mt-2 space-y-2 text-sm font-semibold uppercase divide-y-2">
                    <div class="flex items-center justify-between">
                        <p>Date Range's Releases Count:</p>
                        <p class="text-xl text-custom-blue">{{ $selected_release->released_dividends_count }}</p>
                    </div>
                    <div class="flex items-center justify-between">
                        <p>Date Range's Releases Amount:</p>
                        <p class="text-xl text-custom-blue">{{ Akaunting\Money\Money::PHP($selected_release->released_dividends_net ?? 0, false) }}</p>
                    </div>
                </div>
                <div class="leading-3 p-4 border my-2 border-slate-700">
                    <p class="font-bold">Release Summary</p>
                    <section class="flex items-center justify-between">
                        <h1 class="text-2xl font-medium text-custom-orange">{{ $selected_release->overall_released_dividends_count }}</h1>
                        <h1 class="text-2xl font-bold text-custom-blue">{{ $selected_release->dividends_count }}</h1>
                    </section>
                    <progress id="file" value="{{ $selected_release->overall_released_dividends_count }}" max="{{ $selected_release->dividends_count }}"></progress>
                    <section class="flex items-center justify-between mt-1">
                        <h1 class="text-sm font-medium text-gray-500">
                            {{ Akaunting\Money\Money::PHP($selected_release->overall_released_dividends_net ?? 0, false) }}</h1>
                        <h1 class="text-sm font-bold text-custom-blue">{{ Akaunting\Money\Money::PHP($selected_release->total_amount, true) }}</h1>
                    </section>
                </div>
            </div>
        @endif
        <h4 class="mt-8 font-bold text-primary-600">Active Cashiers</h4>
        <div class="grid grid-cols-3 gap-2 pb-4" wire:poll.2000ms>
            @foreach ($cashiers as $cashier)
                <div class="flex flex-col justify-between p-3 bg-white border rounded-md">
                    <section>
                        <p class="font-medium text-gray-500">{{ $cashier->first_name . ' ' . $cashier->surname }}</p>
                    </section>

                    <div class="leading-3">
                        <section class="flex justify-between text-xs">
                            <div>
                                <h3>Total Releases</h3>
                                <h3 class="text-2xl font-medium text-custom-orange">{{ $cashier->cashier_released_dividends_count }}</h3>
                            </div>
                            <div>
                                <h3>Amount Released</h3>
                                <h3 class="text-lg font-medium text-custom-blue">
                                    {{ Akaunting\Money\Money::PHP($cashier->cashier_released_dividends_net ?? 0, false) }}</h3>
                            </div>
                        </section>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
