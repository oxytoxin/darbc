<div x-data>
    <div class="flex m-1 border-black flex-col font-serif border-2 max-w-[24rem]" x-ref="print">
        <h3 class="px-12 font-bold text-center text-lime-600">Dolefil Agrarian Reform Beneficiaries Cooperative (DARBC)</h3>
        <div class="text-sm">
            <div class="flex px-4">
                <p class="flex-1 italic font-bold text-red-600 underline">MEMBER'S COPY</p>
                <p class="font-bold">Member's No.</p>
                <p class="w-20">&nbsp;{{ $dividend->user->member_information->darbc_id }}</p>
            </div>
            <div class="flex px-4">
                <p class="font-bold">Name:</p>
                <p class="flex-1">&nbsp;{{ $dividend->user->full_name }}</p>
            </div>
            <div class="flex px-4">
                <p class="flex-1">&nbsp;</p>
                <p class="font-bold">Date:</p>
                <p class="w-20">&nbsp;{{ $dividend->created_at->format('m/d/Y') }}</p>
            </div>
            <div class="mt-2 text-center border-black border-y-2">
                <p class="p-2 underline">{{ $dividend->release->name }}</p>
            </div>
            <div class="p-2 text-xs">
                <div>
                    <p class="font-semibold underline">Dividend Sharing</p>
                </div>
                <div class="flex">
                    <p class="flex-1">Fix Profit Share</p>
                    <p class="w-3/5 text-center">&nbsp;{{ Akaunting\Money\Money::PHP($dividend->net_amount, true) }}</p>
                </div>
                @foreach ($dividend->particulars as $key => $value)
                    <div class="flex">
                        <p class="flex-1">{{ $key }}</p>
                        <p class="w-3/5 text-center">&nbsp;{{ $value }}</p>
                    </div>
                @endforeach
                <div class="flex mt-2">
                    <p class="flex-1 font-semibold">Total Dividends</p>
                    <p class="w-3/5 text-center">&nbsp;{{ Akaunting\Money\Money::PHP($dividend->net_amount, true) }}</p>
                </div>
                <div class="flex">
                    <p class="flex-1 font-semibold">Net Dividends</p>
                    <p class="w-3/5 text-right underline">&nbsp;{{ Akaunting\Money\Money::PHP($dividend->net_amount, true) }}</p>
                </div>
            </div>
            <div class="flex border-t-2 border-black">
                <p class="flex-1 py-4 italic font-semibold text-center underline border-r-2 border-black">SIGNATURE</p>
                <p class="w-3/5">&nbsp;</p>
            </div>
        </div>
    </div>
    <x-filament-support::button @click="printOut($refs.print.outerHTML)">Print</x-filament-support::button>
    <script>
        function printOut(data) {
            var mywindow = window.open('', 'Report On Paid Petty Cash Vouchers', 'height=1000,width=1000');
            mywindow.document.write('<html><head>');
            mywindow.document.write('<title>Report On Paid Petty Cash Vouchers</title>');
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
