@props(['member'])

<div class="mb-4 flex flex-col items-center space-y-4">
    <div class="mb-4">
        <img class="h-32 w-32 rounded-full border-4 border-primary-600" src="{{ $member->profile_photo }}" alt="avatar">
    </div>
    <div class="grid w-full grid-cols-4">
        <div>
            <h4 class="text-lg font-semibold">{{ $member->user->name }}</h4>
            <h5 class="text-sm font-semibold text-gray-600">
                {{ $member->succession_number == '0' ? 'Original Owner' : ordinal($member->succession_number) . ' Successor' }}
            </h5>
        </div>
        <div>
            <h4 class="text-lg font-semibold">Age: {{ now()->diffInYears($member->date_of_birth) == 0 ? 'Unknown' : now()->diffInYears($member->date_of_birth) }}</h4>
            <h5 class="text-sm font-semibold text-gray-600">
                Birthday: {{ $member->date_of_birth?->format('F d, Y') ?? 'Unknown' }}
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
    </div>
    <div>
        <p class="text-center font-semibold text-gray-600">Address</p>
        <p class="text-center text-lg font-bold">{{ filled($member->address_line) ? $member->address_line : 'No address found.' }}</p>
    </div>
</div>
