<div class="simple-card">
    <div class="grid grid-cols-5">
        <div>
            <h4 class="text-lg font-semibold">{{ $member->user->full_name }}</h4>
            <h5 class="text-sm font-semibold text-gray-600">
                {{ $member->succession_number == '0' ? 'Original Owner' : ordinal($member->succession_number) . ' Successor' }}
            </h5>
        </div>
        <div>
            <p class="font-semibold text-gray-600">DARBC ID</p>
            <p class="text-lg font-bold">{{ $member->darbc_id }}</p>
        </div>
        <div>
            <p class="font-semibold text-gray-600">Share Percentage</p>
            <p class="text-lg font-bold">{{ $member->percentage }} %</p>
        </div>
        <div>
            <p class="font-semibold text-gray-600">Amount to Release</p>
            <p class="text-lg font-bold">{{ Akaunting\Money\Money::PHP($dividends_amount_to_claim, true) }}</p>
        </div>
        <div>
            <p class="font-semibold text-gray-600">Release Status</p>
            @if ($member->user->active_restriction)
                <div>
                    <span class="bg-red-500/[8%] py-1 px-4 rounded-full text-red-700">on-hold</span>
                </div>
            @else
                <div>
                    <span class="bg-custom-green/[8%] py-1 px-4 rounded-full text-custom-green">release</span>
                </div>
            @endif
        </div>
    </div>
    <div class="flex mt-4">
        <div class="w-1/3">
            <p class="font-semibold">Account Ownership</p>
            <div>
                @foreach ($lineage_members as $lineage_member)
                    <div class="flex items-center gap-2 @if (!$loop->first) px-8 @endif">
                        @if (!$loop->first)
                            <svg width="16" height="16" viewBox="0 0 5 7" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M2.0702 3.72808L0.0385742 1.78091L1.05403 0.806641L4.1011 3.72808L1.05403 6.64952L0.0385742 5.67525L2.0702 3.72808Z" fill="#EF9A47" />
                            </svg>
                        @endif
                        <div>
                            <p class="flex items-center gap-2">
                                <a href="{{ route(request()->route()->getName(),['member' => $lineage_member]) }}">{{ $lineage_member->user->full_name }}</a>
                                <a class="text-xs font-bold text-green-700 underline" href="{{ $this->getEditRoute($lineage_member->id) }}">EDIT</a>
                            </p>
                            <h5 class="text-xs font-semibold text-gray-400">
                                {{ $lineage_member->succession_number == '0' ? 'Original Owner' : ordinal($lineage_member->succession_number) . ' Successor' }}
                                @if ($lineage_member->id == $member->id)
                                    <span class="text-green-600">(Current)</span>
                                @endif
                            </h5>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="flex-1">
            <table class="table w-full border border-collapse table-auto">
                <thead class="text-left text-white bg-primary-500">
                    <tr>
                        <th></th>
                        <th class="px-2">Release Name</th>
                        <th class="px-2">Amount</th>
                        <th class="px-2">Date of Release</th>
                        <th class="px-2">Status</th>
                    </tr>
                <tbody>
                    @php
                        $isCashier = auth()
                            ->user()
                            ->roles()
                            ->where('name', 'cashier')
                            ->exists();
                    @endphp
                    @forelse ($dividends_by_year as $year => $dividends)
                        @foreach ($dividends as $dividend)
                            <tr>
                                @if ($loop->first)
                                    <td class="
                                    @if ($loop->parent->odd) bg-[#E3E3E3]
                                    @else
                            bg-[#EF9A47] @endif py-4" rowspan="{{ count($dividends) }}">
                                        <p class="text-center -rotate-90">{{ $year }}</p>
                                    </td>
                                @endif
                                <td class="px-2 py-2 border-b">{{ $dividend->release->name }}</td>
                                <td class="px-2 py-2 border-b">{{ Akaunting\Money\Money::PHP($dividend->net_amount, true) }}
                                </td>
                                <td class="px-2 py-2 border-b">{{ $dividend->release->created_at->format('F d, Y') }}</td>
                                <td class="px-2 py-2 border-b">
                                    <a class="px-2 py-1 text-xs font-semibold rounded-full {{ match ($dividend->status) {
                                        App\Models\Dividend::PENDING => 'bg-yellow-200 text-yellow-800',
                                        App\Models\Dividend::FOR_RELEASE => 'bg-success-200 text-success-800 underline',
                                        App\Models\Dividend::ON_HOLD => 'bg-red-200 text-red-800',
                                        App\Models\Dividend::RELEASED => 'bg-gray-200 text-gray-800',
                                    } }}"
                                       href="{{ $dividend->status == App\Models\Dividend::FOR_RELEASE && $isCashier ? route('cashier.dividends.manage', ['dividend' => $dividend]) : ' #' }}">{{ match ($dividend->status) {
                                           App\Models\Dividend::PENDING => 'Pending',
                                           App\Models\Dividend::FOR_RELEASE => 'For Release',
                                           App\Models\Dividend::ON_HOLD => 'On Hold',
                                           App\Models\Dividend::RELEASED => 'Released',
                                       } }}
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    @empty
                        <tr>
                            <td class="py-4 text-sm text-center" colspan="5">No dividends found for this user.</td>
                        </tr>
                    @endforelse
                </tbody>
                </thead>
            </table>
        </div>
    </div>
</div>
