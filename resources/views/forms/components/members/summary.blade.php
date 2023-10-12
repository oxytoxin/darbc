@php
    $user = App\Models\User::make([
        'first_name' => $this->data['first_name'],
        'middle_name' => $this->data['middle_name'],
        'surname' => $this->data['surname'],
        'suffix' => $this->data['suffix'],
        'username' => str($this->data['first_name'])
            ->slug('')
            ->append('-' . now()->timestamp)
            ->toString(),
    ]);

    $isReplacement = $this->data['membership_status'] == 2;
    $succession_number = 0;
    $original_member_id = null;
    if ($isReplacement && $this->data['replacement_member']) {
        $toReplace = App\Models\MemberInformation::firstWhere('user_id', $this->data['replacement_member']);
        $succession_number = $toReplace->succession_number + 1;
        $original_member_id = $toReplace->user_id;
    }

    $member_information = App\Models\MemberInformation::make([
        'status' => $this->data['status'],
        'darbc_id' => $this->data['darbc_id'],
        'user_id' => $user->id,
        'cluster_id' => $this->data['cluster_id'],
        'succession_number' => $succession_number,
        'original_member_id' => $original_member_id,
        'date_of_birth' => $this->data['date_of_birth'],
        'place_of_birth' => $this->data['place_of_birth'],
        'gender_id' => $this->data['gender_id'],
        'blood_type' => $this->data['blood_type'],
        'religion' => $this->data['religion'],
        'membership_status_id' => $this->data['membership_status'],
        'occupation_id' => $this->data['occupation'],
        'occupation_details' => $this->data['occupation_details'],
        'address_line' => $this->data['address']['address_line'],
        'civil_status' => $this->data['civil_status'],
        'children' => collect($this->data['children'])->values(),
        'sss_number' => $this->data['sss_number'],
        'philhealth_number' => $this->data['philhealth_number'],
        'tin_number' => $this->data['tin_number'],
        'contact_number' => $this->data['contact_number'],
        'application_date' => $this->data['application_date'],
    ]);
@endphp
<div class="text-sm">
    <h3 class="text-xl font-bold text-primary-500">Summary</h3>
    <div class="mt-8 space-y-4">
        <div class="grid grid-cols-2 gap-2">
            <p>
                <span class="font-semibold">First Name: </span>
                <span>{{ $user->first_name }}</span>
            </p>
            <p>
                <span class="font-semibold">Last Name: </span>
                <span>{{ $user->surname }}</span>
            </p>
            <p>
                <span class="font-semibold">Middle Name: </span>
                <span>{{ $user->middle_name }}</span>
            </p>
            <p>
                <span class="font-semibold">Suffix: </span>
                <span>{{ $user->suffix }}</span>
            </p>
            <p>
                <span class="font-semibold">Username: </span>
                <span>{{ $user->username }}</span>
            </p>
        </div>
        <hr>
        <div class="grid grid-cols-2 gap-2">
            <p>
                <span class="font-semibold">Membership: </span>
                <span>{{ $member_information->membership_status->name }}</span>
            </p>
            @if ($isReplacement && $this->data['replacement_member'])
                <p>
                    <span class="font-semibold">Member to Replace: </span>
                    <span>{{ $member_information->original_member->full_name }}</span>
                </p>
            @endif
            <p>
                <span class="font-semibold">Status: </span>
                <span>{{ match (strval($member_information->status)) {
                    default => '',
                    strval(App\Models\MemberInformation::STATUS_ACTIVE) => 'Active',
                    strval(App\Models\MemberInformation::STATUS_DECEASED) => 'Deceased',
                    strval(App\Models\MemberInformation::STATUS_INACTIVE) => 'Inactive',
                } }}</span>
            </p>
        </div>
        <hr>
        <div class="grid grid-cols-2 gap-2">
            <p>
                <span class="font-semibold">Address: </span>
                <span>{{ $member_information->address_line }}</span>
            </p>
        </div>
        <hr>
        <p>
            <span class="font-semibold">Occupation: </span>
            <span>{{ $member_information->occupation->name }}</span>
        </p>
        @if ($member_information->occupation_details)
            <p>
                <span class="font-semibold">Occupation: </span>
                <span>{{ $member_information->occupation_details }}</span>
            </p>
        @endif
        <p>
            <span class="font-semibold">Civil Status: </span>
            <span>{{ match (strval($member_information->civil_status)) {
                default => '',
                '1' => 'Single',
                '2' => 'Married',
                '3' => 'Widowed',
            } }}</span>
        </p>
        @if (count($member_information->children))
            <div>
                <p class="font-semibold">Children: </p>
                <table class="table w-full mt-2 border border-black divide-y divide-black table-auto">
                    <thead>
                        <tr class="divide-x divide-black">
                            <th>Name</th>
                            <th>Date of Birth</th>
                            <th>Educational Attainment</th>
                            <th>Blood Type</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-black">
                        @foreach ($member_information->children as $child)
                            <tr class="text-center divide-x divide-black">
                                <td>{{ $child['name'] }}</td>
                                <td>{{ isset($child['date_of_birth']) ? date_format(date_create($child['date_of_birth']), 'F d, Y') : '' }}</td>
                                <td>{{ $child['educational_attainment'] }}</td>
                                <td>{{ $child['blood_type'] }}</td>
                            </tr>
                        @endforeach
                    </tbody>

                </table>
            </div>
        @endif
        <hr>
        <div class="grid grid-cols-2 gap-2">
            <p>
                <span class="font-semibold">DARBC ID: </span>
                <span>{{ $member_information->darbc_id }}</span>
            </p>
            <p>
                <span class="font-semibold">SSS Number: </span>
                <span>{{ $member_information->sss_number }}</span>
            </p>
            <p>
                <span class="font-semibold">PhilHealth Number: </span>
                <span>{{ $member_information->philhealth_number }}</span>
            </p>
            <p>
                <span class="font-semibold">TIN Number: </span>
                <span>{{ $member_information->tin_number }}</span>
            </p>
        </div>
        <hr>
        <p>
            <span class="font-semibold">Cluster: </span>
            <span>{{ $member_information->cluster?->name }}</span>
        </p>
    </div>
</div>
