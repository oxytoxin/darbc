<div>
    <div class="mt-10" x-data>
        <div class="flex justify-between mb-2">
            <h1 class="text-xl font-bold text-custom-blue">Cashier Cash Monitoring Report</h1>
            <x-filament::button icon="heroicon-o-printer" @click="printOut($refs.data.outerHTML, 'Cash Monitoring Report')">Cash Monitoring Report</x-filament::button>
        </div>
        <div class="my-4 flex gap-2">
            <label for="from">
                <p>From</p>
                <input id="from" type="date" wire:model="from">
            </label>
            <label for="to">
                <p>To</p>
                <input id="to" type="date" wire:model="to">
            </label>
        </div>
        <div class="text-[10pt]" x-ref="data">
            <div>
                <h1 class="font-bold">Dolefil Agrarian Reform Beneficiaries Cooperative</h1>
                <h2 class="italic">{{ $release->name }}</h2>
                <h3 class="italic">Advance Profit Share</h3>
            </div>
            <div class="mt-4 w-1/2">
                <h2 class="font-bold">I. Cash Monitoring Report</h2>
                <div class="px-3">
                    <table class="w-full text-[10pt]">
                        <thead>
                            <tr>
                                <th class="whitespace-nowrap text-left">Cash Beginning</th>
                                <th></th>
                                <th></th>
                                <th class="whitespace-nowrap text-right px-2">{{ number_format($release->total_amount, 2) }}</th>
                            </tr>
                            <tr>
                                <th></th>
                                <th class="whitespace-nowrap font-normal text-right px-4">{{ $release->name }}</th>
                                <th class="whitespace-nowrap font-normal text-right px-4">Unclaimed Shares</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $unclaimed_total = 0;
                            @endphp
                            @forelse ($releases_total_by_date as $release_data)
                                @php
                                    $unclaimed = ($daily_cash_starts_by_date->firstWhere('date', $release_data['date'])['total'] ?? 0) - $release_data['total'];
                                    $unclaimed_total += $unclaimed;
                                @endphp
                                <tr>
                                    <td class="whitespace-nowrap text-right font-bold">{{ $release_data['date'] }}</td>
                                    <td class="whitespace-nowrap text-right px-4">{{ number_format($release_data['total'], 2) }}</td>
                                    <td class="whitespace-nowrap text-right px-4">{{ number_format($unclaimed, 2) }}</td>
                                    <td></td>
                                </tr>
                            @empty
                                <tr>
                                    <td></td>
                                    <td class="whitespace-nowrap text-center" colspan="2">No dividend releases found</td>
                                    <td></td>
                                </tr>
                            @endforelse
                            @php
                                $total_cash_released = $releases_total_by_date->sum('total') + $unclaimed_total;
                                $cash_end = $release->total_amount - $total_cash_released;
                                $cash_short_over = $cash_end - $daily_cash_ends_total;
                            @endphp
                            <tr>
                                <td class="whitespace-nowrap font-bold">Total Cash Released</td>
                                <td class="whitespace-nowrap font-bold text-right px-4">{{ number_format($releases_total_by_date->sum('total'), 2) }}</td>
                                <td class="whitespace-nowrap font-bold text-right px-4">{{ number_format($unclaimed_total, 2) }}</td>
                                <td class="whitespace-nowrap font-bold border-b-2 border-black text-right pr-2">{{ number_format($total_cash_released, 2) }}</td>
                            </tr>
                            <tr>
                                <td class="whitespace-nowrap font-bold">Cash End</td>
                                <td></td>
                                <td></td>
                                <td class="whitespace-nowrap font-bold text-right pr-2">{{ number_format($cash_end, 2) }}</td>
                            </tr>
                            <tr>
                                <td class="whitespace-nowrap font-bold">Actual Cash, End</td>
                                <td></td>
                                <td></td>
                                <td class="whitespace-nowrap font-bold border-b-2 border-black text-right pr-2">{{ number_format($daily_cash_ends_total, 2) }}</td>
                            </tr>
                            <tr>
                                <td class="whitespace-nowrap font-bold">Cash Short (over)</td>
                                <td></td>
                                <td></td>
                                <td class="whitespace-nowrap font-bold border-b-4 border-black text-right pr-2 border-double">{{ number_format($cash_short_over, 2) }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <hr class="my-4 border-4 border-primary-600">
            <div class="flex gap-16">
                <div>
                    <h2 class="font-bold">IV. ACTUAL CASH END CASH COUNT</h2>
                    <div class="px-4">
                        <table class="text-[10pt]">
                            <thead>
                                <tr>
                                    <th class="px-4">Denomination</th>
                                    <th class="px-4">Count</th>
                                    <th class="px-4">Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $daily_cash_end_total = 0;
                                @endphp
                                @forelse ($daily_cash_end_denominations ?? [] as $denomination => $count)
                                    <tr>
                                        <td class="text-right px-4">{{ $denomination }}</td>
                                        <td class="text-center px-4">{{ $count }}</td>
                                        <td class="text-right px-4">{{ number_format($denomination * $count, 2) }}</td>
                                    </tr>
                                    @php
                                        $daily_cash_end_total += $denomination * $count;
                                    @endphp
                                @empty
                                    <tr>
                                        <td class="text-center" colspan="3">No cash end records found</td>
                                    </tr>
                                @endforelse
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td class="font-bold px-4">Cash, End</td>
                                    <td></td>
                                    <td class="font-bold text-right px-4 border-b-4 border-black border-double">{{ number_format($daily_cash_end_total, 2) }}</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
                <div class="p-8">
                    <h5>Cash Count Verified By:</h5>
                    <div class="pl-20 mt-10">
                        <p class="text-center font-bold uppercase">{{ auth()->user()->full_name }}e</p>
                        <p class="text-center">Senior Cashier</p>
                    </div>
                    <div class="mt-12">
                        <p>AR# issued: </p>
                    </div>
                </div>
            </div>
            <hr class="mt-2 border-4 border-primary-600">
            <div class="my-4 flex">
                <p class="flex-1">Prepared by:</p>
                <p class="flex-1">Verified by:</p>
                <p class="flex-1">Received by:</p>
            </div>
        </div>
    </div>
</div>
