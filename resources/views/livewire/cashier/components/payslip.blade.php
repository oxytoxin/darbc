<div class="m-4 flex" :class="orientation == 'vertical' ? 'flex-col max-w-sm' : 'flex-row'" x-ref="print">
    @foreach (["MEMBER'S", 'DARBC'] as $copy)
        <div class="relative m-1 flex flex-col border-2 border-black font-serif">
            <h3 class="px-12 text-center text-sm font-bold text-lime-600">Dolefil Agrarian Reform Beneficiaries Cooperative (DARBC)</h3>
            <img class="absolute right-0 top-0 w-12" src="{{ asset('assets/darbc-logo.svg') }}" alt="darbc">
            <div class="text-sm">
                <div class="flex px-4">
                    <p class="flex-1 font-bold italic text-red-600 underline">{{ $copy }} COPY</p>
                    <p class="font-bold">Member's No.</p>
                    <p class="w-12">&nbsp;{{ $dividend->user->member_information->darbc_id }}</p>
                </div>
                <div class="mt-4 flex px-4 text-xs">
                    <p class="font-bold">Name:</p>
                    <p class="flex-1">&nbsp;{{ $dividend->user->full_name }}</p>
                </div>
                @if ($dividend->claimed_by)
                    <div class="flex px-4 text-xs">
                        <p class="font-bold">{{ $dividend->claim_type == 2 ? 'SPA' : 'Authorized Representative' }}:&nbsp;</p>
                        <p class="flex-1">{{ $dividend->claimed_by }}</p>
                    </div>
                @endif
                <div class="flex px-4 text-xs">
                    <p class="flex-1">&nbsp;</p>
                    <p class="font-bold">Date:</p>
                    <p class="w-20 font-sans font-semibold">&nbsp;{{ $dividend->released_at->format('m/d/Y') }}</p>
                </div>
                <div class="flex px-4 text-xs">
                    <p class="flex-1">&nbsp;</p>
                    <p class="font-bold">Time:</p>
                    <p class="w-20 font-sans font-semibold">&nbsp;{{ $dividend->released_at->format('h:i A') }}</p>
                </div>
                <div class="mt-2 border-y-2 border-black text-center">
                    <p class="p-2 underline">{{ $dividend->release->name }}</p>
                </div>
                <div class="p-4">
                    @if (filled($dividend->breakdown))
                        @foreach ($dividend->breakdown['add'] as $key => $item)
                            <div class="flex justify-between">
                                <p>{{ $item['name'] }}</p>
                                <p>&nbsp;{{ number_format($item['value'], 2) }}</p>
                            </div>
                        @endforeach
                        <div class="flex justify-between">
                            <p>LESS:</p>
                            <p>&nbsp;</p>
                        </div>
                        @foreach ($dividend->breakdown['less'] as $key => $item)
                            <div class="flex justify-between">
                                <p>{{ $item['name'] }}</p>
                                <p>&nbsp;{{ number_format($item['value'], 2) }}</p>
                            </div>
                        @endforeach
                        <div class="flex justify-between">
                            <p>NET PAY:</p>
                            <p>&nbsp;{{ number_format($dividend->net_amount, 2) }}</p>
                        </div>
                    @else
                        <div class="flex justify-between">
                            <p>GROSS AMOUNT:</p>
                            <p>&nbsp;{{ number_format($dividend->gross_amount, 2) }}</p>
                        </div>
                        <div class="flex justify-between">
                            <p>TOTAL DEDUCTIONS:</p>
                            <p>&nbsp;{{ number_format($dividend->deductions_amount, 2) }}</p>
                        </div>
                        <div class="flex justify-between">
                            <p>{{ $dividend->release->share_description }}</p>
                            <p>&nbsp;{{ number_format($dividend->net_amount, 2) }}</p>
                        </div>
                    @endif
                </div>
                <div class="space-y-2 px-4 py-4 text-sm">
                    {{-- <div class="flex justify-between">
                        <p>{{ $dividend->release->share_description }}</p>
                        <p>&nbsp;{{ $dividend->claimed ? Akaunting\Money\Money::PHP($dividend->net_amount, true) : 'UNCLAIMED' }}</p>
                    </div> --}}
                    @if (!$dividend->user->member_information->split_claim && ($dividend->release->gift_certificate_prefix || $dividend->release->gift_certificate_amount > 0))
                        <div class="flex justify-between">
                            <p>Gift Certificate <br><span class="ml-2 text-xs font-semibold">(worth {{ Akaunting\Money\Money::PHP($dividend->release->gift_certificate_amount, true) }})</span></p>
                            <p class="font-sans font-semibold">{{ $dividend->gift_certificate_control_number ? $dividend->release->gift_certificate_prefix . $dividend->gift_certificate_control_number : 'UNCLAIMED' }}</p>
                        </div>
                    @endif
                    @foreach ($dividend->particulars as $key => $value)
                        <div class="flex justify-between">
                            <p>{{ $value['name'] }}</p>
                            <p>&nbsp;{{ $dividend->release->particulars[$value['name']] ?? '' }}</p>
                            {{-- <p>&nbsp;{{ $value['claimed'] ? $dividend->release->particulars[$value['name']] : 'UNCLAIMED' }}</p> --}}
                        </div>
                    @endforeach
                </div>
                <div class="flex divide-x-2 divide-black border-t-2 border-black">
                    <div class="flex h-24 flex-1 flex-col px-4 py-4">
                        <p class="text-xs font-semibold italic">TELLER NAME:</p>
                        <div class="flex-1">&nbsp;</div>
                        <p class="whitespace-nowrap text-center text-xs uppercase">{{ $dividend->cashier->first_name . ' ' . $dividend->cashier->surname }}</p>
                    </div>
                    <div class="flex h-24 flex-1 flex-col px-4 py-4">
                        @php
                            $claim_type_name = match ($dividend->claim_type) {
                                1 => 'MEMBER',
                                2 => 'SPA',
                                3 => 'REPRESENTATIVE',
                                default => 'MEMBER',
                            };
                        @endphp
                        <p class="text-xs font-semibold italic">{{ $claim_type_name }}'S SIGNATURE</p>
                        <div class="flex-1">&nbsp;</div>
                        @if ($dividend->claimed_by)
                            <p class="whitespace-nowrap text-center text-xs uppercase">{{ $dividend->claimed_by }}</p>
                        @else
                            <p class="whitespace-nowrap text-center text-xs uppercase">{{ $dividend->user->full_name }}</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>
