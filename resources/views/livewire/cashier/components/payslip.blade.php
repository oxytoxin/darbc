<div class="flex" x-ref="print">
    @foreach (["MEMBER'S", 'DARBC'] as $copy)
        <div class="relative flex flex-col m-1 font-serif border-2 border-black">
            <h3 class="px-12 text-sm font-bold text-center text-lime-600">Dolefil Agrarian Reform Beneficiaries Cooperative (DARBC)</h3>
            <img class="absolute top-0 right-0 w-12" src="{{ asset('assets/darbc-logo.svg') }}" alt="darbc">
            <div class="text-sm">
                <div class="flex px-4">
                    <p class="flex-1 italic font-bold text-red-600 underline">{{ $copy }} COPY</p>
                    <p class="font-bold">Member's No.</p>
                    <p class="w-12">&nbsp;{{ $dividend->user->member_information->darbc_id }}</p>
                </div>
                <div class="flex px-4 mt-4 text-xs">
                    <p class="font-bold">Name:</p>
                    <p class="flex-1">&nbsp;{{ $dividend->user->full_name }}</p>
                </div>
                @if ($dividend->claimed_by)
                    <div class="px-4 text-xs">
                        <p class="font-bold">SPA/Authorized Representative:</p>
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
                <div class="mt-2 text-center border-black border-y-2">
                    <p class="p-2 underline">{{ $dividend->release->name }}</p>
                </div>
                <div class="px-4 py-4 space-y-2 text-sm">
                    <div class="flex justify-between">
                        <p>Advance Profit Share</p>
                        <p>&nbsp;{{ $dividend->claimed ? Akaunting\Money\Money::PHP($dividend->net_amount, true) : 'UNCLAIMED' }}</p>
                    </div>
                    @if (!$this->dividend->user->member_information->split_claim && ($dividend->release->gift_certificate_prefix || $dividend->release->gift_certificate_amount > 0))
                        <div class="flex justify-between">
                            <p>Gift Certificate <br><span class="ml-2 text-xs font-semibold">(worth {{ Akaunting\Money\Money::PHP($dividend->release->gift_certificate_amount, true) }})</span></p>
                            <p class="font-sans font-semibold">{{ $dividend->gift_certificate_control_number ? $dividend->release->gift_certificate_prefix . $dividend->gift_certificate_control_number : 'UNCLAIMED' }}</p>
                        </div>
                    @endif
                    @foreach ($dividend->particulars as $key => $value)
                        <div class="flex justify-between">
                            <p>{{ $value['name'] }}</p>
                            <p>&nbsp;{{ $value['claimed'] ? $dividend->release->particulars[$value['name']] : 'UNCLAIMED' }}</p>
                        </div>
                    @endforeach
                </div>
                <div class="flex border-t-2 border-black divide-x-2 divide-black">
                    <div class="flex flex-col flex-1 h-24 px-4 py-4">
                        <p class="text-xs italic font-semibold">CASHIER NAME:</p>
                        <div class="flex-1">&nbsp;</div>
                        <p class="text-xs text-center uppercase whitespace-nowrap">{{ $dividend->cashier->first_name . ' ' . $dividend->cashier->surname }}</p>
                    </div>
                    <div class="flex flex-col flex-1 h-24 px-4 py-4">
                        <p class="text-xs italic font-semibold">{{ $dividend->claimed_by ? "REPRESENTATIVE'S" : "MEMBER'S" }} SIGNATURE</p>
                        <div class="flex-1">&nbsp;</div>
                        @if ($dividend->claimed_by)
                            <p class="text-xs text-center uppercase whitespace-nowrap">{{ $dividend->claimed_by }}</p>
                        @else
                            <p class="text-xs text-center uppercase whitespace-nowrap">{{ $dividend->user->full_name }}</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>
