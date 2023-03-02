<div class="max-w-[60rem]" x-data>
    @include('livewire.cashier.components.payslip')
    <div class="mt-4">
        <x-filament-support::button @click="printOut($refs.print.outerHTML)">Print</x-filament-support::button>
        <x-filament-support::button href="{{ route('cashier.releases.dividends', ['release' => $dividend->release]) }}" color="success" tag="a">RELEASE ANOTHER</x-filament-support::button>
    </div>
    <script>
        function printOut(data) {
            var mywindow = window.open('', 'DARBC PAYSLIP', 'height=1000,width=1000');
            mywindow.document.write('<html><head>');
            mywindow.document.write('<title>DARBC PAYSLIP</title>');
            mywindow.document.write(`<link rel="stylesheet" href="{{ Vite::asset('resources/css/app.css') }}" />`);
            mywindow.document.write('</head><body >');
            mywindow.document.write(data);
            mywindow.document.write('<script>(' + (function() {
                function checkReadyState() {
                    if (document.readyState === 'complete') {
                        window.focus();
                        window.print();
                        window.close();
                    } else {
                        setTimeout(checkReadyState, 500); // May need to change interval
                    }
                }
                checkReadyState();
            }) + ')();</sc' + 'ript>');
            mywindow.document.write('</body></html>');

            mywindow.document.close();
            mywindow.focus();
            return true;
        }
    </script>
</div>
