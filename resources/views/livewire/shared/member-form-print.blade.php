<div x-data class="my-10">
    <div class="space-y-8">
        <h1 class="text-xl font-bold text-primary-500">Print Member Form</h1>
    </div>
    <div x-ref="print" class="mx-auto max-w-4xl space-y-4 bg-white p-4">
        <div class="flex">
            <div class="flex items-center gap-8 flex-1">
                <img class="w-[5rem] h-[5rem]" src="/assets/darbc-logo.svg" alt="darbc logo">
                <h2 class="font-bold">DOLEFIL AGRARIAN REFORM BENEFICIARIES COOPERATIVE (DARBC) MEMBERSHIP</h2>
            </div>
            <div class="mb-4">
                <img class="w-32 h-32" src="{{ $member->profile_photo }}" alt="avatar">
            </div>
        </div>
        <div class="flex gap-2">
            <h4 class="font-bold">Name:</h4>
            <h4>{{ $member->user->alt_full_name }}</h4>
        </div>

        <div class="flex justify-between gap-2">
            <div class="flex gap-2">
                <h4 class="font-bold">Date of Birth:</h4>
                <h4>{{ $member->date_of_birth->format('F d, Y') }}</h4>
            </div>
            <div class="flex gap-2">
                <h4 class="font-bold">Age:</h4>
                <h4>{{ $member->age }}</h4>
            </div>
            <div class="flex gap-2">
                <h4 class="font-bold">Place of Birth:</h4>
                <h4>{{ $member->place_of_birth }}</h4>
            </div>
        </div>

        <div class="flex justify-between">
            <div class="flex gap-2">
                <h4 class="font-bold">Membership Status:</h4>
                <h4>{{ $member->succession_number > 0 ? 'Replacement' : 'Regular' }}</h4>
            </div>
            @if ($member->succession_number > 0)
                <div class="flex gap-2">
                    <h4 class="font-bold">Succession:</h4>
                    <h4>{{ ordinal($member->succession_number) . ' Successor' }}</h4>
                </div>
            @endif
        </div>

        <div class="flex gap-2">
            <h4 class="font-bold">Address:</h4>
            <h4>{{ $member->address_line }}</h4>
        </div>

        <div class="flex justify-between">
            <div class="flex gap-2">
                <h4 class="font-bold">Gender:</h4>
                <h4 class="uppercase">{{ $member->gender?->name }}</h4>
            </div>
            <div class="flex gap-2">
                <h4 class="font-bold">Mother's Maiden Name:</h4>
                <h4>{{ $member->mother_maiden_name }}</h4>
            </div>
        </div>
        <div class="flex justify-between">
            <div class="space-y-4">
                <div class="flex gap-2">
                    <h4 class="font-bold">Religion:</h4>
                    <h4 class="uppercase">{{ $member->religion }}</h4>
                </div>
                <div class="flex gap-2">
                    <h4 class="font-bold">Blood Type:</h4>
                    <h4 class="uppercase">{{ $member->blood_type }}</h4>
                </div>
                <div class="flex gap-2">
                    <h4 class="font-bold">Civil Status:</h4>
                    <h4>{{ match ($member->civil_status) {
                        1 => 'SINGLE',
                        2 => 'MARRIED',
                        3 => 'WIDOW',
                        4 => 'LEGALLY_SEPARATED',
                        5 => 'UNKNOWN',
                    } }}</h4>
                </div>
            </div>

            <div class="flex gap-2">
                <h4 class="font-bold">Occupation:</h4>
                <h4 class="uppercase">{{ $member->occupation?->name . ' ' . $member->occupation_details }}</h4>
            </div>
        </div>

        @if (filled($member->spouse))
            <div class="flex gap-2">
                <h4 class="font-bold">Name of Spouse:</h4>
                <h4>{{ $member->spouse }}</h4>
            </div>
        @endif

        <div class="">
            <h4 class="font-bold">Children Information</h4>
            <table class="border border-black w-full">
                <thead>
                    <tr>
                        <th class="border min-w-[10rem] border-black">Name</th>
                        <th class="border border-black">Date of Birth</th>
                        <th class="border border-black">Educational Attainment</th>
                        <th class="border border-black">Blood Type</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($member->children as $child)
                        <tr>
                            <td class="border border-black">{{ $child['name'] }}</td>
                            <td class="border border-black">{{ $child['date_of_birth'] ? date_create($child['date_of_birth'])->format('F d, Y') : '' }}</td>
                            <td class="border border-black">{{ $child['educational_attainment'] }}</td>
                            <td class="border border-black">{{ $child['blood_type'] }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td class="border border-black text-center font-bold" colspan="4">No children</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div class="flex gap-2">
                <h4 class="font-bold">SSS Number:</h4>
                <h4>{{ $member->sss_number }}</h4>
            </div>
            <div class="flex gap-2">
                <h4 class="font-bold">PhilHealth Number:</h4>
                <h4>{{ $member->philhealth_number }}</h4>
            </div>
            <div class="flex gap-2">
                <h4 class="font-bold">TIN Number:</h4>
                <h4>{{ $member->tin_number }}</h4>
            </div>
            <div class="flex gap-2">
                <h4 class="font-bold">DARBC I.D. Number:</h4>
                <h4>{{ $member->darbc_id }}</h4>
            </div>
            <div class="flex gap-2">
                <h4 class="font-bold">Contact Number:</h4>
                <h4>{{ $member->contact_number }}</h4>
            </div>
            <div class="flex gap-2">
                <h4 class="font-bold">Cluster Number:</h4>
                <h4>{{ $member->cluster?->name }}</h4>
            </div>
            <div class="flex gap-2">
                <h4 class="font-bold">Date:</h4>
                <h4>{{ $member->application_date?->format('F d, Y') }}</h4>
            </div>
            <div class="flex gap-2">
                <h4 class="font-bold">Signature of Member:</h4>
                <h4>&nbsp;</h4>
            </div>
        </div>
    </div>
    <div class="max-w-4xl flex justify-end mx-auto mt-16">
        <x-filament-support::button icon="heroicon-o-printer" @click="printOut($refs.print.outerHTML, 'RELEASE PAYSLIP')">Print</x-filament-support::button>
    </div>
</div>
