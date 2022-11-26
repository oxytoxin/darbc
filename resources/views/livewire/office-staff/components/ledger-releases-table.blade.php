<table class="min-w-full border divide-y divide-gray-500">
    <thead class="bg-primary-500">
        <tr>
            <th scope="col" class="w-[17rem] py-2.5 text-white px-3 text-left font-semibold col-span-3">Name</th>
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
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 6H5.25A2.25 2.25 0 003 8.25v10.5A2.25 2.25 0 005.25 21h10.5A2.25 2.25 0 0018 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25" />
                                </svg>
                            </a>
                        @endif

                    </div>
                </th>
            @endforeach
            <th scope="col" class="w-[7rem] py-2.5 text-white px-3 font-semibold border text-center leading-4"></th>
            <th scope="col" class="w-[7rem] py-2.5 text-white px-3 font-semibold border text-center leading-4">Status</th>
            <th scope="col" class="w-[10rem] py-2.5 text-white px-3 font-semibold border-r text-center leading-4">Amount to claim</th>
        </tr>
    </thead>
    <tbody class="divide-y divide-gray-200">
        @forelse ($records as $user)
            <tr>
                <td class="py-3 pl-3 text-sm font-bold bg-gray-100 border whitespace-nowrap">
                    <a href="{{ route('office-staff.manage-member-restrictions', ['member' => $user->member_information]) }}">
                        <p>{{ $user->full_name }}</p>
                        <p class="text-gray-500">{{ $user->member_information->darbc_id }}</p>
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
