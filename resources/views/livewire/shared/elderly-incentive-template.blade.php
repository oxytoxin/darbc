<div x-data class="max-w-6xl mx-auto">
    <div class="p-16 mx-auto" x-ref="print">
        <div class="flex">
            <img class="h-24" src="{{ asset('assets/darbc-logo.svg') }}" alt="logo">
            <div>
                <h1 class="text-center font-extrabold text-red-600">DOLEFIL AGRARIAN REFORM BENEFICIARIES COOPERATIVE</h1>
                <h3 class="text-center text-green-600 font-semibold">(DARBC)</h3>
                <h3 class="text-center font-semibold">DARBC BLDG., CANNERY SITE, POLOMOLOK, SOUTH COTABATO</h3>
                <h5 class="text-center font-bold">REQUEST FOR PAYMENT</h5>
            </div>
        </div>
        <div>
            <h4 class="flex mb-1 justify-end items-center gap-2">
                <strong>Date: </strong>
                <div x-data="{ date: '{{ today()->format('Y-m-d') }}' }">
                    <input x-model="date" type="date" class="text-xs print:hidden font-bold">
                    <strong x-text="(new Date(date)).toLocaleDateString()" class="text-sm hidden print:block"></strong>
                </div>
            </h4>
            <div class="border-2 border-black">
                <div class="border-b-2  p-1 border-black">
                    <div x-data="{ checked: 2 }" class="flex justify-end gap-4 font-semibold">
                        <div class="flex items-center gap-1">
                            <input @change="checked = 1" :checked="checked == 1" type="checkbox">
                            <span>Request for Cash</span>
                        </div>
                        <div class="flex items-center gap-1">
                            <input @change="checked = 2" :checked="checked == 2" type="checkbox">
                            <span>Request for Check</span>
                        </div>
                    </div>
                    <div class="flex justify-between">
                        <h4>Pay To: <strong>{{ $incentive->user->alt_full_name }}</strong></h4>
                        <h4 class="flex items-center gap-2">
                            <strong>Check Date:</strong>
                            <div x-data="{ date: '{{ today()->format('Y-m-d') }}' }">
                                <input x-model="date" type="date" class="text-xs print:hidden font-bold">
                                <strong x-text="(new Date(date)).toLocaleDateString()" class="text-sm hidden print:block"></strong>
                            </div>
                        </h4>
                    </div>
                </div>
                <div class="border-b-2  p-1 border-black flex items-center gap-4">
                    <h4>Amount:</h4>
                    <select wire:model="incentive_id" class="text-xs font-bold print:hidden">
                        @foreach ($user->elderly_incentives as $elderly_incentive)
                            <option value="{{ $elderly_incentive->id }}">{{ strtoupper($elderly_incentive->amount_in_words) }}</option>
                        @endforeach
                    </select>
                    <strong class="text-sm hidden print:block">{{ strtoupper($incentive->amount_in_words) }}</strong>
                </div>

                <div class="flex text-sm">
                    <div class="w-2/3 py-4">
                        <div class="border-b-2 p-1 border-black">
                            <h3 class="font-bold">Explanation:</h3>
                            <h3 class="pl-16 mt-4">Elderly Incentive Program</h3>
                        </div>
                        <div class="p-1">
                            <h3 class="font-bold">Requested By:</h3>
                            <div class="px-8 mt-4 gap-4 flex items-end justify-end">
                                <div class="flex items-center flex-col">
                                    <div class="border-b-2 border-black w-full text-center">
                                        <h3 class="mx-8 font-semibold whitespace-nowrap">JATALLEDO</h3>
                                    </div>
                                    <h3 class="text-sm">Signature over Printed Name</h3>
                                </div>
                                <div class="flex items-center flex-col">
                                    <div x-data="{ date: '{{ today()->format('Y-m-d') }}' }" class="border-b-2 border-black w-full text-center">
                                        <input x-model="date" type="date" class="text-xs print:hidden font-bold">
                                        <strong x-text="(new Date(date)).toLocaleDateString()" class="text-sm hidden print:block"></strong>
                                    </div>
                                    <h3>Date</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                    <table class="border-2 w-1/3 text-sm m-1 border-black border-collapse">
                        <thead>
                            <tr>
                                <th class="px-4 border-2 border-black">Account No.</th>
                                <th class="px-8 border-2 border-black">Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class=" border-2 border-black"></td>
                                <td class="text-center border-2 border-black">{{ Akaunting\Money\Money::PHP($incentive->amount, true) }}</td>
                            </tr>
                            <tr>
                                <td class=" border-2 border-black"></td>
                                <td class="text-center border-2 border-black">&nbsp;</td>
                            </tr>
                            <tr>
                                <td class=" border-2 border-black"></td>
                                <td class="text-center border-2 border-black">&nbsp;</td>
                            </tr>
                            <tr>
                                <td class=" border-2 border-black"></td>
                                <td class="text-center border-2 border-black">&nbsp;</td>
                            </tr>
                            <tr>
                                <td class=" border-2 border-black"></td>
                                <td class="text-center border-2 border-black">&nbsp;</td>
                            </tr>
                            <tr class="font-bold">
                                <td class="text-center border-2 border-black">Total</td>
                                <td class="text-center border-2 border-black">{{ Akaunting\Money\Money::PHP($incentive->amount, true) }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="flex border-black items-end border-2 pb-2 pt-8 gap-2 text-xs mt-2 justify-evenly">
            <div class="flex items-end gap-4">
                <div class="flex items-center flex-col">
                    <div class="border-b-2 border-black w-full text-center">
                        <h3 class="font-semibold">JETBELARMA</h3>
                    </div>
                    <h3 class="text-xs text-center">Membership Supervisor</h3>
                </div>
                <div class="flex items-center flex-col">
                    <div x-data="{ date: '{{ today()->format('Y-m-d') }}' }" class="border-b-2 border-black w-full text-center">
                        <input x-model="date" type="date" class="text-xs print:hidden font-bold">
                        <strong x-text="(new Date(date)).toLocaleDateString()" class="text-sm hidden print:block"></strong>
                    </div>
                    <h3 class="text-xs text-center">Date</h3>
                </div>
            </div>
            <div class="flex items-end gap-4">
                <div class="flex items-center flex-col">
                    <div class="border-b-2 border-black w-full text-center">
                        <h3 class="font-semibold">MFSMANLANGIT</h3>
                    </div>
                    <h3 class="text-xs text-center">Dept. Head, CAD</h3>
                </div>
                <div class="flex items-center flex-col">
                    <div x-data="{ date: '{{ today()->format('Y-m-d') }}' }" class="border-b-2 border-black w-full text-center">
                        <input x-model="date" type="date" class="text-xs print:hidden font-bold">
                        <strong x-text="(new Date(date)).toLocaleDateString()" class="text-sm hidden print:block"></strong>
                    </div>
                    <h3 class="text-xs text-center">Date</h3>
                </div>
            </div>
            <div class="flex items-end gap-4">
                <div class="flex items-center flex-col">
                    <div class="border-b-2 border-black w-full text-center">
                        <h3 class="font-semibold">ANNIE GRACE G. BEGOTA</h3>
                    </div>
                    <h3 class="text-xs text-center">Dept. Head, Accounting</h3>
                </div>
                <div class="flex items-center flex-col">
                    <div x-data="{ date: '{{ today()->format('Y-m-d') }}' }" class="border-b-2 border-black w-full text-center">
                        <input x-model="date" type="date" class="text-xs print:hidden font-bold">
                        <strong x-text="(new Date(date)).toLocaleDateString()" class="text-sm hidden print:block"></strong>
                    </div>
                    <h3 class="text-xs text-center">Date</h3>
                </div>
            </div>
        </div>
    </div>
    <div class="flex justify-end">
        <x-filament-support::button icon="heroicon-o-printer" @click="printOut($refs.print.outerHTML, 'RELEASE PAYSLIP')">Print</x-filament-support::button>
    </div>

</div>
