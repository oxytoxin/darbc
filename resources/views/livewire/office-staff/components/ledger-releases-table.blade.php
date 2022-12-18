<div class="relative">
    <div wire:loading.delay wire:target="tableFilters" class="absolute inset-0 z-30 bg-white">
        <div class="grid w-full h-full place-items-center">
            <p class="animate-bounce">Loading data...</p>
        </div>
    </div>
    <table class="min-w-full border divide-y divide-gray-500">
        <thead class="bg-primary-500">
            <tr>
                <th scope="col" class="py-2.5 min-w-[6rem] text-white px-3 text-left font-semibold col-span-3">
                    DARBC ID
                </th>
                <th scope="col" class="py-2.5 min-w-[12rem] text-white px-3 text-left font-semibold col-span-3">
                    Last Name
                    <x-tables::search-input class="text-black" wire-model="tableColumnSearchQueries.surname" />
                </th>
                <th scope="col" class="py-2.5 min-w-[12rem] text-white px-3 text-left font-semibold col-span-3">
                    First Name
                    <x-tables::search-input class="text-black" wire-model="tableColumnSearchQueries.first_name" />
                </th>
                @foreach ($releases as $release)
                    <th scope="col" class="w-[8rem] py-2.5 text-white px-3 font-semibold @if ($release->disbursed) bg-custom-green
                    @else
                    bg-yellow-500 @endif border-r">
                        <div class='flex items-center space-x-3'>
                            <div title="{{ $release->name }}" class="flex flex-col flex-1 leading-4">
                                <span class="text-sm">{{ $release->created_at->format('M d') }}</span>
                                <h1 class="flex-1 whitespace-nowrap">{{ str($release->name)->limit(10) }}</h1>
                            </div>
                            @if ($release->disbursed)
                                <a href="{{ route('office-staff.ledger.release-details', ['release' => $release]) }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 6H5.25A2.25 2.25 0 003 8.25v10.5A2.25 2.25 0 005.25 21h10.5A2.25 2.25 0 0018 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25" />
                                    </svg>
                                </a>
                            @else
                                <a href="{{ route('office-staff.ledger.release-dividends', ['release' => $release]) }}">
                                    <svg class="w-5 h-5" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <g clip-path="url(#clip0_109_6206)">
                                            <path
                                                d="M5.10741 2.15018C5.15241 1.87918 5.38741 1.68018 5.66241 1.68018H6.95891C7.23391 1.68018 7.46891 1.87918 7.51391 2.15018L7.62041 2.79068C7.65191 2.97768 7.77691 3.13368 7.94291 3.22568C7.97991 3.24568 8.01641 3.26718 8.05291 3.28918C8.21491 3.38718 8.41291 3.41768 8.59041 3.35118L9.19891 3.12318C9.3236 3.07628 9.4609 3.07517 9.58634 3.12003C9.71179 3.1649 9.81723 3.25283 9.88391 3.36818L10.5319 4.49168C10.5984 4.60703 10.6219 4.74224 10.5981 4.87326C10.5743 5.00428 10.5048 5.1226 10.4019 5.20718L9.90041 5.62068C9.75391 5.74068 9.68141 5.92718 9.68491 6.11668C9.68571 6.15917 9.68571 6.20168 9.68491 6.24418C9.68141 6.43318 9.75391 6.61918 9.89991 6.73918L10.4024 7.15318C10.6144 7.32818 10.6694 7.63018 10.5324 7.86818L9.88341 8.99168C9.81683 9.10699 9.7115 9.19496 9.58616 9.23991C9.46082 9.28486 9.3236 9.28389 9.19891 9.23718L8.59041 9.00918C8.41291 8.94268 8.21541 8.97318 8.05241 9.07118C8.01616 9.09322 7.97948 9.11455 7.94241 9.13518C7.77691 9.22668 7.65191 9.38268 7.62041 9.56968L7.51391 10.2097C7.46891 10.4812 7.23391 10.6802 6.95891 10.6802H5.66191C5.38691 10.6802 5.15191 10.4812 5.10691 10.2102L5.00041 9.56968C4.96941 9.38268 4.84441 9.22668 4.67841 9.13468C4.64133 9.11423 4.60466 9.09305 4.56841 9.07118C4.40591 8.97318 4.20841 8.94268 4.03041 9.00918L3.42191 9.23718C3.29727 9.28394 3.16009 9.28498 3.03476 9.24012C2.90942 9.19526 2.80406 9.10741 2.73741 8.99218L2.08891 7.86868C2.02238 7.75332 1.99893 7.61811 2.02273 7.48709C2.04654 7.35608 2.11605 7.23775 2.21891 7.15318L2.72091 6.73968C2.86691 6.61968 2.93941 6.43318 2.93591 6.24368C2.93512 6.20118 2.93512 6.15867 2.93591 6.11618C2.93941 5.92718 2.86691 5.74118 2.72091 5.62118L2.21891 5.20718C2.11618 5.12262 2.04674 5.00439 2.02294 4.87349C1.99914 4.74258 2.02251 4.60748 2.08891 4.49218L2.73741 3.36868C2.804 3.25324 2.90941 3.1652 3.03486 3.12024C3.16031 3.07528 3.29765 3.07632 3.42241 3.12318L4.03041 3.35118C4.20841 3.41768 4.40591 3.38718 4.56841 3.28918C4.60441 3.26718 4.64141 3.24568 4.67841 3.22518C4.84441 3.13368 4.96941 2.97768 5.00041 2.79068L5.10741 2.15018V2.15018Z"
                                                stroke="white" stroke-linecap="round" stroke-linejoin="round" />
                                            <path
                                                d="M7.81055 6.18018C7.81055 6.578 7.65251 6.95953 7.37121 7.24084C7.0899 7.52214 6.70837 7.68018 6.31055 7.68018C5.91272 7.68018 5.53119 7.52214 5.24989 7.24084C4.96858 6.95953 4.81055 6.578 4.81055 6.18018C4.81055 5.78235 4.96858 5.40082 5.24989 5.11952C5.53119 4.83821 5.91272 4.68018 6.31055 4.68018C6.70837 4.68018 7.0899 4.83821 7.37121 5.11952C7.65251 5.40082 7.81055 5.78235 7.81055 6.18018V6.18018Z"
                                                stroke="white" stroke-linecap="round" stroke-linejoin="round" />
                                        </g>
                                    </svg>
                                </a>
                            @endif

                        </div>
                    </th>
                @endforeach
                <th scope="col" class="py-2.5 text-white px-3 font-semibold border text-center leading-4">&nbsp;</th>
                <th scope="col" class="w-[7rem] py-2.5 text-white px-3 font-semibold border text-center leading-4">Status
                </th>
                <th scope="col" class="w-[10rem] py-2.5 text-white px-3 font-semibold border-r text-center leading-4">Amount</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-200">
            @forelse ($records as $user)
                <tr>
                    <td class="py-3 pl-3 text-sm font-bold bg-gray-100 border whitespace-nowrap">
                        <a href="{{ route('office-staff.member-dividends', ['member' => $user->member_information]) }}">
                            <p>{{ $user->member_information->darbc_id }}</p>
                        </a>
                    </td>
                    <td class="py-3 pl-3 text-sm font-bold bg-gray-100 border whitespace-nowrap">
                        <a href="{{ route('office-staff.member-dividends', ['member' => $user->member_information]) }}">
                            <p>{{ $user->surname }}</p>
                        </a>
                    </td>
                    <td class="py-3 pl-3 text-sm font-bold bg-gray-100 border whitespace-nowrap">
                        <a href="{{ route('office-staff.member-dividends', ['member' => $user->member_information]) }}">
                            <p>{{ $user->first_name }}</p>
                        </a>
                    </td>
                    @php
                        $amount_to_claim = 0;
                    @endphp
                    @foreach ($releases as $release)
                        @php
                            $dividend = $user->dividends->firstWhere('release_id', $release->id);
                        @endphp
                        @if ($dividend)
                            <td
                                class="whitespace-nowrap py-4 px-3 text-sm font-semibold text-center w-[7rem] border @switch($dividend->status)
                                @case(App\Models\Dividend::PENDING)
                                text-custom-orange
                                    @break
                                @case(App\Models\Dividend::FOR_RELEASE)
                                text-green-500
                                    @break
                                @case(App\Models\Dividend::ON_HOLD)
                                text-red-500
                                    @break
                                @case(App\Models\Dividend::RELEASED)
                                text-gray-500
                                    @break
                                @default
                            @endswitch">
                                {{ Akaunting\Money\Money::PHP($dividend?->net_amount ?? 0, true) }}
                            </td>
                            @php
                                $amount_to_claim += $dividend?->net_amount;
                            @endphp
                        @else
                            <td class="whitespace-nowrap py-4 px-3 text-sm font-semibold text-center border text-red-500 w-[7rem]">
                            </td>
                        @endif
                    @endforeach
                    <td class="px-3 py-3 text-sm font-semibold text-center whitespace-nowrap">&nbsp;</td>
                    <td class="px-3 py-3 text-sm font-semibold text-center border whitespace-nowrap">
                        @if ($user->active_restriction)
                            <div class="bg-red-500/[8%] py-1 rounded-full text-red-700">on-hold</div>
                        @else
                            <div class="bg-custom-green/[8%] py-1 rounded-full text-custom-green">release</div>
                        @endif
                    </td>
                    <td class="px-3 py-3 text-sm font-semibold text-center whitespace-nowrap">{{ Akaunting\Money\Money::PHP($amount_to_claim ?? 0, true) }}</td>
                </tr>
            @empty
            @endforelse
        </tbody>
    </table>
</div>
