<div class="simple-card">
    <div class="grid grid-cols-4">
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
                            <a href="{{ route(request()->route()->getName(),['member' => $lineage_member]) }}">{{ $lineage_member->user->full_name }}</a>
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
    </div>
</div>
