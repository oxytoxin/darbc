<div class="text-sm border-r-2 border-black pr-8 mb-8 w-1/2">
    <div class="flex">
        <h2 class="font-bold">LANE NO. : </h2>
        <p class="border-b-2 font-bold text-center border-black min-w-[6rem]">{{ $this->lane }}</p>
    </div>
    <div>
        <div class="flex justify-evenly mt-4">
            <p class="font-bold flex-1">Cash Beginning</p>
            <div class="flex-1 flex">
                <p>DATE: </p>
                <p class="border-b border-black flex-1"></p>
            </div>
        </div>
        @if ($this->daily_cash_start)
            <table class="w-full border mt-1 border-black border-collapse">
                <thead>
                    <tr>
                        <th class="w-20 border border-black">Denom</th>
                        <th class="border border-black">Qty</th>
                        <th class="border border-black">Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($this->daily_cash_start->denominations as $denomination_entry)
                        <tr>
                            <td class="text-center border border-black">{{ $denomination_entry['denomination'] }}</td>
                            <td class="text-center border border-black">{{ $denomination_entry['count'] }}</td>
                            @php
                                $row_total = $denomination_entry['denomination'] * $denomination_entry['count'];
                            @endphp
                            <td class="text-center border border-black">{{ number_format($row_total, 2) }}</td>
                        </tr>
                    @endforeach
                    @php
                        $grand_count_total = collect($this->daily_cash_start->denominations)->sum('count');
                        $grand_amount_total = collect($this->daily_cash_start->denominations)
                            ->map(fn($d) => $d['denomination'] * $d['count'])
                            ->sum();
                    @endphp
                    <tr>
                        <td class="font-bold border text-center border-black">TOTAL</td>
                        <td class="text-center border border-black">{{ $grand_count_total }}</td>

                        <td class="text-center border border-black">{{ number_format($grand_amount_total, 2) }}</td>
                    </tr>
                </tbody>
            </table>
        @endif
        <div class="mt-1 space-y-2">
            <p>Received by:</p>
            <div class="flex">
                <p class="flex-1 italic text-xs">Name, Signature & Date</p>
                <p class="flex-1 border-b-2 border-black"></p>
            </div>
        </div>
    </div>
    <div class="mt-2">
        <p class="font-bold">Actual Cash, End</p>
        @if ($this->daily_cash_end)
            <table class="w-full border mt-1 border-black border-collapse">
                <thead>
                    <tr>
                        <th class="w-20 border border-black">Denom</th>
                        <th class="border border-black">Qty</th>
                        <th class="border border-black">Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($this->daily_cash_end->denominations as $denomination_entry)
                        <tr>
                            <td class="text-center border border-black">{{ $denomination_entry['denomination'] }}</td>
                            <td class="text-center border border-black">{{ $denomination_entry['count'] }}</td>
                            @php
                                $row_total = $denomination_entry['denomination'] * $denomination_entry['count'];
                            @endphp
                            <td class="text-center border border-black">{{ number_format($row_total, 2) }}</td>
                        </tr>
                    @endforeach
                    @php
                        $grand_count_total = collect($this->daily_cash_start->denominations)->sum('count');
                        $grand_amount_total = collect($this->daily_cash_start->denominations)
                            ->map(fn($d) => $d['denomination'] * $d['count'])
                            ->sum();
                    @endphp
                    <tr>
                        <td class="font-bold border text-center border-black">TOTAL</td>
                        <td class="text-center border border-black">{{ $grand_count_total }}</td>

                        <td class="text-center border border-black">{{ number_format($grand_amount_total, 2) }}</td>
                    </tr>
                </tbody>
            </table>
        @endif

    </div>
    <div class="mt-2">
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
        <div class="space-y-2">
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
            <div>
                <p>RETURNED BY:</p>
                <p class="border-b border-black ml-24 text-center uppercase">{{ auth()->user()->full_name }}</p>
            </div>
            <div>
                <p>CHECKED BY:</p>
                <p class="border-b border-black ml-24 text-center uppercase">&nbsp;</p>
            </div>
        </div>
    </div>
</div>
