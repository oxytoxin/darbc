<div x-data class="max-w-[45rem]">
    <div class="flex" x-ref="print">
        <div class="relative flex flex-col m-1 font-serif border-2 border-black">
            <h3 class="px-12 text-sm font-bold text-center text-lime-600">Dolefil Agrarian Reform Beneficiaries Cooperative (DARBC)</h3>
            <img class="absolute top-0 right-0 w-12" src="{{ asset('assets/darbc-logo.svg') }}" alt="darbc">
            <div class="text-sm">
                <div class="flex px-4">
                    <p class="flex-1 italic font-bold text-red-600 underline">MEMBER'S COPY</p>
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
                <div class="px-4 py-2 text-xs">
                    <div class="flex justify-between">
                        <p>Advance Profit Share</p>
                        <p>&nbsp;{{ Akaunting\Money\Money::PHP($dividend->net_amount, true) }}</p>
                    </div>
                    @foreach ($dividend->release->particulars as $key => $value)
                        <div class="flex justify-between">
                            <p>{{ $key }}@if (!str($value)->contains(['sets', 'set', 'cans', 'can']))
                                    ({{ $value }})
                                @endif
                            </p>
                            @if (!str($value)->contains(['sets', 'set', 'cans', 'can']))
                                <p class="font-sans font-semibold">&nbsp;{{ $dividend->release->control_number_prefix . $dividend->particulars[$key] }}</p>
                            @else
                                <p>&nbsp;{{ $dividend->particulars[$key] ? $value : 'UNCLAIMED' }}</p>
                            @endif
                        </div>
                    @endforeach
                </div>
                <div class="flex border-t-2 border-black divide-x-2 divide-black">
                    <div class="flex flex-col flex-1 h-40 px-4 py-4">
                        <p class="text-xs italic font-semibold">CASHIER NAME:</p>
                        <div class="flex-1">&nbsp;</div>
                        <p class="text-xs text-center uppercase whitespace-nowrap">{{ $dividend->cashier->first_name . ' ' . $dividend->cashier->surname }}</p>
                    </div>
                    <div class="flex flex-col flex-1 h-40 px-4 py-4">
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
        <div class="relative flex flex-col m-1 font-serif border-2 border-black">
            <h3 class="px-12 text-sm font-bold text-center text-lime-600">Dolefil Agrarian Reform Beneficiaries Cooperative (DARBC)</h3>
            <img class="absolute top-0 right-0 w-12" src="{{ asset('assets/darbc-logo.svg') }}" alt="darbc">
            <div class="text-sm">
                <div class="flex px-4">
                    <p class="flex-1 italic font-bold text-red-600 underline">DARBC COPY</p>
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
                <div class="px-4 py-2 text-xs">
                    <div class="flex justify-between">
                        <p>Advance Profit Share</p>
                        <p>&nbsp;{{ Akaunting\Money\Money::PHP($dividend->net_amount, true) }}</p>
                    </div>
                    @foreach ($dividend->release->particulars as $key => $value)
                        <div class="flex justify-between">
                            <p>{{ $key }}@if (!str($value)->contains(['sets', 'set', 'cans', 'can']))
                                    ({{ $value }})
                                @endif
                            </p>
                            @if (!str($value)->contains(['sets', 'set', 'cans', 'can']))
                                <p class="font-sans font-semibold">&nbsp;{{ $dividend->release->control_number_prefix . $dividend->particulars[$key] }}</p>
                            @else
                                <p>&nbsp;{{ $dividend->particulars[$key] ? $value : 'UNCLAIMED' }}</p>
                            @endif
                        </div>
                    @endforeach
                </div>
                <div class="flex border-t-2 border-black divide-x-2 divide-black">
                    <div class="flex flex-col flex-1 h-40 px-4 py-4">
                        <p class="text-xs italic font-semibold">CASHIER NAME:</p>
                        <div class="flex-1">&nbsp;</div>
                        <p class="text-xs text-center uppercase whitespace-nowrap">{{ $dividend->cashier->first_name . ' ' . $dividend->cashier->surname }}</p>
                    </div>
                    <div class="flex flex-col flex-1 h-40 px-4 py-4">
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
    </div>
    <x-filament-support::button @click="printOut($refs.print.outerHTML)">Print</x-filament-support::button>
    <script>
        function printOut(data) {
            var mywindow = window.open('', 'DARBC PAYSLIP', 'height=1000,width=1000');
            mywindow.document.write('<html><head>');
            mywindow.document.write('<title>DARBC PAYSLIP</title>');
            mywindow.document.write(`<link rel="stylesheet" href="{{ Vite::asset('resources/css/app.css') }}" />`);
            mywindow.document.write('</head><body >');
            mywindow.document.write(data);
            mywindow.document.write('</body></html>');

            mywindow.document.close();
            mywindow.focus();

            mywindow.print();
            return true;
        }
    </script>
</div>
