<div x-data>
    <div class="p-16 mx-auto" x-ref="print">
        <div class="flex">
            <img class="px-16" src="{{ asset('assets/darbc-logo.svg') }}" alt="logo">
            <div class="text-center flex-1">
                <h1 class="font-extrabold text-red-600">DOLEFIL AGRARIAN REFORM BENEFICIARIES COOPERATIVE</h1>
                <h3 class="text-green-600 font-semibold">(DARBC)</h3>
                <h3 class="font-semibold">DARBC BLDG., CANNERY SITE, POLOMOLOK, SOUTH COTABATO</h3>
                <h5 class="font-bold">REQUEST FOR PAYMENT</h5>
            </div>
        </div>
        <div>
            <h4 class="flex justify-end gap-2"><strong>Date: </strong><span>{{ today()->format('m/d/Y') }}</span></h4>
            <div class="border-2 border-black">
                <div class="border-b-2  p-1 border-black">
                    <div class="flex justify-end gap-4 font-semibold">
                        <div class="flex items-center gap-1">
                            <input disabled type="checkbox">
                            <span>Request for Cash</span>
                        </div>
                        <div class="flex items-center gap-1">
                            <input disabled type="checkbox" checked>
                            <span>Request for Check</span>
                        </div>
                    </div>
                    <div class="flex justify-between">
                        <h4>Pay To: <strong>{{ $incentive->user->full_name }}</strong></h4>
                        <h4><strong>Check Date:</strong> {{ $incentive->created_at->format('F d, Y') }}</h4>
                    </div>
                </div>
                <div class="border-b-2  p-1 border-black">
                    <h4>Amount: <strong>{{ strtoupper($incentive->amount_in_words) }} PESOS ONLY</strong></h4>
                </div>

                <div class="flex">
                    <div class="flex-1 py-4">
                        <div class="border-b-2 p-1 border-black">
                            <h3 class="font-bold">Explanation:</h3>
                            <h3 class="pl-16 mt-4">Elderly Incentive Program</h3>
                        </div>
                        <div class="p-1">
                            <h3 class="font-bold">Requested By:</h3>
                            <div class="px-8 mt-4 gap-4 flex justify-end">
                                <div class="flex items-center flex-col">
                                    <div class="border-b-2 border-black w-full text-center">
                                        <h3 class="mx-8 whitespace-nowrap">{{ $incentive->user->full_name }}</h3>
                                    </div>
                                    <h3 class="text-sm">Signature over Printed Name</h3>
                                </div>
                                <div class="flex items-center flex-col">
                                    <div class="border-b-2 border-black w-full text-center">
                                        <h3 class="mx-8">{{ today()->format('m/d/Y') }}</h3>
                                    </div>
                                    <h3>Date</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                    <table class="border m-1 border-black border-collapse">
                        <thead>
                            <tr>
                                <th class="px-4 border border-black">Account No.</th>
                                <th class="px-8 border border-black">Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class=" border border-black"></td>
                                <td class="text-center border border-black">{{ Akaunting\Money\Money::PHP($incentive->amount, true) }}</td>
                            </tr>
                            <tr>
                                <td class=" border border-black"></td>
                                <td class="text-center border border-black">&nbsp;</td>
                            </tr>
                            <tr>
                                <td class=" border border-black"></td>
                                <td class="text-center border border-black">&nbsp;</td>
                            </tr>
                            <tr>
                                <td class=" border border-black"></td>
                                <td class="text-center border border-black">&nbsp;</td>
                            </tr>
                            <tr>
                                <td class=" border border-black"></td>
                                <td class="text-center border border-black">&nbsp;</td>
                            </tr>
                            <tr class="font-bold">
                                <td class="text-center border border-black">Total</td>
                                <td class="text-center border border-black">{{ Akaunting\Money\Money::PHP($incentive->amount, true) }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="flex border-black border-2 pb-2 pt-8 gap-2 text-xs mt-2 justify-center">
            <div class="flex items-center flex-col">
                <div class="border-b-2 border-black w-full text-center">
                    <h3 class="font-semibold">JETBELARMA</h3>
                </div>
                <h3 class="text-xs text-center">Membership Supervisor</h3>
            </div>
            <div class="flex items-center flex-col">
                <div class="border-b-2 border-black w-full text-center">
                    <h3 class="font-semibold">{{ today()->format('m/d/Y') }}</h3>
                </div>
                <h3 class="text-xs text-center">Date</h3>
            </div>
            <div class="flex items-center flex-col">
                <div class="border-b-2 border-black w-full text-center">
                    <h3 class="font-semibold">MFSMANLANGIT</h3>
                </div>
                <h3 class="text-xs text-center">Dept. Head, CAD</h3>
            </div>
            <div class="flex items-center flex-col">
                <div class="border-b-2 border-black w-full text-center">
                    <h3 class="font-semibold">{{ today()->format('m/d/Y') }}</h3>
                </div>
                <h3 class="text-xs text-center">Date</h3>
            </div>
            <div class="flex items-center flex-col">
                <div class="border-b-2 border-black w-full text-center">
                    <h3 class="font-semibold">ANNIE GRACE G. BEGOTA</h3>
                </div>
                <h3 class="text-xs text-center">Dept. Head, Accounting</h3>
            </div>
            <div class="flex items-center flex-col">
                <div class="border-b-2 border-black w-full text-center">
                    <h3 class="mx-8">&nbsp;</h3>
                </div>
                <h3 class="text-xs text-center">Date</h3>
            </div>
        </div>
    </div>
    <div class="flex justify-end">
        <x-filament-support::button icon="heroicon-o-printer" @click="printOut($refs.print.outerHTML, 'RELEASE PAYSLIP')">Print</x-filament-support::button>
    </div>

</div>
