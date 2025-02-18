<div class="max-w-7xl mx-auto">
    <p class="text-xs font-bold uppercase text-right ">Revised Version: 03-2021</p>
    <div class="border-2 border-black">
        <div class="">
            <div class="grid grid-cols-4">
                <!-- Left Side: Logo & Title -->
                <div class="col-span-3  border-r-2 border-black p-4 ">
                    <div class="flex items-center space-x-4">
                        <img src="{{ asset('assets/darbc-logo.svg') }}" alt="DA Logo" class="h-16 w-16">
                        <div>
                            <h1 class="text-3xl font-extrabold uppercase leading-none">ANI AT KITA <br> RSBSA Enrollment
                                Form</h1>
                            <p class="text-sm font-semibold uppercase text-gray-700 mt-1">Registry System for Basic
                                Sectors in Agriculture (RSBSA)</p>
                        </div>
                    </div>

                    <!-- Enrollment Type & Date -->
                    <div class="flex items-center mt-4">
                        <p class="text-xs font-bold uppercase min-w-[160px]">Enrollment Type & <br> Date Administered:
                        </p>
                        <div class="flex items-center space-x-4">
                            <div class="flex items-center space-x-1">
                                <x-checkbox-display :checked="$rsbsa->isNew()" />
                                <span class="text-sm">New</span>
                            </div>
                            <div class="flex items-center space-x-1">
                                <x-checkbox-display :checked="$rsbsa->isUpdating()" />
                                <span class="text-sm">Updating</span>
                            </div>
                        </div>


                        <!-- Date Boxes -->
                        <div class="ml-6">
                            @php
                                $dateDigits = $rsbsa->getFormattedUpdatedAt();
                            @endphp
                            <div class="flex space-x-1">
                                @foreach ($dateDigits as $digit)
                                    <div
                                        class="border border-black w-6 h-6 text-center text-xs flex items-center justify-center">
                                        {{ $digit }}
                                    </div>
                                @endforeach
                            </div>
                            <div class="flex space-x-1 uppercase text-center text-xs mt-1">
                                <span class="w-6">M</span>
                                <span class="w-6">M</span>
                                <span class="w-6">D</span>
                                <span class="w-6">D</span>
                                <span class="w-6">Y</span>
                                <span class="w-6">Y</span>
                                <span class="w-6">Y</span>
                                <span class="w-6">Y</span>
                            </div>
                        </div>

                    </div>

                    <!-- Reference Number -->
                    @php
                        $codes = $rsbsa->getFormattedLocationCodes();
                    @endphp

                    <div class="flex mt-4">
                        <p class="font-semibold italic text-xs mr-4 min-w-[160px]">Reference Number:</p>
                        <div class="flex space-x-2">
                            <!-- Region -->
                            <div class="flex flex-col">
                                <div class="flex border border-black">
                                    @foreach ($codes['region'] as $index => $digit)
                                        <div
                                            class="w-6 h-6 flex items-center justify-center text-xs {{ $loop->last ? '' : 'border-r border-black' }}">
                                            {{ $digit }}
                                        </div>
                                    @endforeach
                                </div>
                                <span class="uppercase text-xs text-center mt-1">Region</span>
                            </div>

                            <!-- Province -->
                            <div class="flex flex-col">
                                <div class="flex border border-black">
                                    @foreach ($codes['province'] as $index => $digit)
                                        <div
                                            class="w-6 h-6 flex items-center justify-center text-xs {{ $loop->last ? '' : 'border-r border-black' }}">
                                            {{ $digit }}
                                        </div>
                                    @endforeach
                                </div>
                                <span class="uppercase text-xs text-center mt-1">Province</span>
                            </div>

                            <!-- City/Municipality -->
                            <div class="flex flex-col">
                                <div class="flex border border-black">
                                    @foreach ($codes['city_municipality'] as $index => $digit)
                                        <div
                                            class="w-6 h-6 flex items-center justify-center text-xs {{ $loop->last ? '' : 'border-r border-black' }}">
                                            {{ $digit }}
                                        </div>
                                    @endforeach
                                </div>
                                <span class="uppercase text-xs text-center mt-1">City/Muni</span>
                            </div>

                            <!-- Barangay -->
                            <div class="flex flex-col">
                                <div class="flex border border-black">
                                    @foreach ($codes['barangay'] as $index => $digit)
                                        <div
                                            class="w-6 h-6 flex items-center justify-center text-xs {{ $loop->last ? '' : 'border-r border-black' }}">
                                            {{ $digit }}
                                        </div>
                                    @endforeach
                                </div>
                                <span class="uppercase text-xs text-center mt-1">Barangay</span>
                            </div>

                            <!-- Last 6 Digits (Always Exists) -->
                            <div class="flex flex-col">
                                <div class="flex border border-black">
                                    @foreach ($codes['last_six'] as $index => $digit)
                                        <div
                                            class="w-6 h-6 flex items-center justify-center text-xs {{ $loop->last ? '' : 'border-r border-black' }}">

                                        </div>
                                    @endforeach
                                </div>
                                <span class="uppercase text-xs text-center mt-1 invisible">""</span>
                            </div>
                        </div>
                    </div>

                </div>

                <!-- Right Side: 2x2 Picture Box -->
                <div class="flex items-center justify-center min-w-[200px]">
                    <a href="{{ $rsbsa->getImage() }}" target="_blank">
                        <img src="{{ $rsbsa->getImage() }}" alt="2x2 Picture"
                            class="w-[140px] h-[140px] object-cover border border-black">
                    </a>
                </div>

            </div>
        </div>




        <div class=" border-black">

            <div class="bg-black text-white font-bold p-1">
                PART I: PERSONAL INFORMATION
            </div>
            <div class="grid grid-cols-12 ">
                <div class="col-span-12">

                    <div class="grid grid-cols-2">
                        <div class="p-2">
                            <x-display-text value="{{ $rsbsa->memberinformation?->user?->surname ?? 'N/A' }}"
                                class="text-center" />

                            <div class="text-center text-xs font-bold uppercase border-t border-black ">Surname</div>
                        </div>
                        <div class="p-2">
                            <x-display-text value="{{ $rsbsa->memberinformation?->user?->surname ?? 'N/A' }}"
                                class="text-center" />
                            <div class="text-center text-xs font-bold uppercase border-t border-black ">First Name</div>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 border-b-2 border-black">
                        <div class="p-2">
                            <x-display-text value="{{ $rsbsa->memberinformation?->user?->middle_name ?? 'N/A' }}"
                                class="text-center" />
                            <div class="text-center text-xs font-bold uppercase border-t border-black ">Middle Name
                            </div>
                        </div>
                        <div class="grid grid-cols-2">
                            <div class="p-2">

                                <x-display-text value="{{ $rsbsa->extension_name }}" class="text-center" />

                                <div class="text-center text-xs font-bold uppercase border-t border-black ">Extension
                                    Name
                                </div>
                            </div>
                            <div
                                class="inline-flex items-center justify-center border-l-2 border-t-2  border-black p-2">
                                <div class="text-xs font-bold uppercase">Sex:</div>
                                <div class="flex items-center space-x-2 ml-2">
                                    <x-checkbox-display
                                        checked="{{ $rsbsa->memberinformation?->gender?->name === 'Male' }}" />

                                    <span class="text-xs">Male</span>
                                </div>
                                <div class="flex items-center space-x-2 ml-4">
                                    <x-checkbox-display
                                        checked="{{ $rsbsa->memberinformation?->gender?->name === 'Female' }}" />
                                    <span class="text-xs">Female</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="  col-span-12">
                    <div class="border-b border-black flex py-4 px-2">
                        <div class="flex">
                            <div class=" font-bold uppercase p-2 w-32 ">Address</div>
                            <div class="flex-1"></div>
                        </div>
                        <div class="grid grid-cols-3 gap-4 p-2 pb-2 flex-1">
                            <div class="flex flex-col">

                                <x-display-text value="{{ $rsbsa->house_lot_bldg_purok ?? 'N/A' }}"
                                    class="border border-black h-8 text-center  text-xs italic p-1" />
                                <span class="text-center text-xs font-bold uppercase ">House/Lot/Bldg. No./Purok</span>
                            </div>
                            <div class="flex flex-col">
                                <x-display-text value="{{ $rsbsa->street_sitio_subdv ?? 'N/A' }}"
                                    class="border border-black h-8 text-center  text-xs italic p-1" />
                                <span class="text-center text-xs font-bold uppercase ">Street/Sitio/Subdv.</span>
                            </div>
                            <div class="flex flex-col">
                                <x-display-text value="{{ $rsbsa->barangay ?? 'N/A' }}"
                                    class="border border-black h-8 text-center  text-xs italic p-1" />
                                <span class="text-center text-xs font-bold uppercase ">Barangay</span>
                            </div>
                            <div class="flex flex-col">
                                <x-display-text value="{{ $rsbsa->city_municipality ?? 'N/A' }}"
                                    class="border border-black h-8 text-center  text-xs italic p-1" />
                                <span class="text-center text-xs font-bold uppercase ">Municipality/City</span>
                            </div>
                            <div class="flex flex-col">
                                <x-display-text value="{{ $rsbsa->province ?? 'N/A' }}"
                                    class="border border-black h-8 text-center  text-xs italic p-1" />
                                <span class="text-center text-xs font-bold uppercase ">Province</span>
                            </div>
                            <div class="flex flex-col">
                                <x-display-text value="{{ $rsbsa->region ?? 'N/A' }}"
                                    class="border border-black h-8 text-center  text-xs italic p-1" />
                                <span class="text-center text-xs font-bold uppercase ">Region</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class=" col-span-12 grid grid-cols-12 ">

                    <div class="col-span-6">
                        <div class="col-span-6 grid grid-cols-6 p-2 border-b-2  border-black ">
                            @php
                                $mobileNumber = $rsbsa->getFormattedContactNumber();
                            @endphp

                            <div class="col-span-3">
                                <p class="text-xs font-bold uppercase">Mobile Number:</p>
                                <div class="flex space-x-0.5">
                                    @foreach (range(0, 10) as $index)
                                        <div
                                            class="border border-black w-6 h-6 text-center text-xs  flex items-center justify-center">
                                            {{ $mobileNumber[$index] ?? '' }}
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            @php
                                $landlineNumber = $rsbsa->getFormattedLandlineNumber();
                            @endphp

                            <div class="col-span-3">
                                <p class="text-xs font-bold uppercase">Landline Number:</p>
                                <div class="flex space-x-0.5">
                                    @foreach (range(0, 9) as $index)
                                        <div
                                            class="border border-black w-6 h-6 text-center text-xs italic flex items-center justify-center">
                                            {{ $landlineNumber[$index] ?? '' }}
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                        </div>
                        <div class="col-span-6 grid grid-cols-6  border-b-2 border-black ">
                            <div class="col-span-3 p-2">
                                <p class="text-xs font-bold uppercase">Date of Birth:</p>
                                <div>
                                    <div class="flex space-x-1">
                                        @foreach ($rsbsa->getFormattedDateOfBirth() as $digit)
                                            <div class="border border-black w-6 h-6 text-center text-xs flex items-center justify-center">
                                                {{ $digit }}
                                            </div>
                                        @endforeach
                                    </div>
                                    <div class="flex space-x-1 uppercase text-center">
                                        <span class="w-6">M</span>
                                        <span class="w-6">M</span>
                                        <span class="w-6">D</span>
                                        <span class="w-6">D</span>
                                        <span class="w-6">Y</span>
                                        <span class="w-6">Y</span>
                                        <span class="w-6">Y</span>
                                        <span class="w-6">Y</span>
                                    </div>
                                </div>
                            </div>

                            <div class="col-span-3 border-l-2 p-2 border-black">
                                <div class="grid grid-cols-2 ">
                                    <p class="text-xs font-bold uppercase col-span-2">Place Of Birth:</p>
                                    <div class="flex flex-col col-span-2">
                                        <x-display-text value="{{ $rsbsa->place_of_birth_municipality ?? '' }}" class="text-center "/>
                                        <span
                                            class="text-center text-[8px] font-bold uppercase border-t border-black">Municipality</span>
                                    </div>
                                    <div class="flex flex-col">
                                        <x-display-text value="{{ $rsbsa->place_of_birth_province ?? '' }}" class="text-center "/>
                                        <span
                                            class="text-center text-[8px] font-bold uppercase border-t border-black">Province/State</span>
                                    </div>
                                    <div class="flex flex-col">

                                     <x-display-text value="{{ $rsbsa->place_of_birth_province ?? '' }}" class="text-center "/>
                                        <span
                                            class="text-center text-[8px] font-bold uppercase border-t border-black">Country</span>
                                    </div>

                                </div>

                            </div>
                        </div>
                        <div class="col-span-6">
                            <!-- Religion & Civil Status Section -->
                            <div class="border-b border-black p-2">
                                <!-- Religion -->
                                <div class="flex items-center">
                                    <span class="text-xs font-bold uppercase mr-2">Religion:</span>

                                    <div class="flex items-center space-x-2 ml-4">

                                        <x-display-text value="{{ $rsbsa->memberInformation?->religion ?? '' }}" class="border-b border-black w-32 h-4 text-xs italic text-center"/>

                                    </div>
                                </div>

                                <!-- Civil Status -->
                                <div class="flex items-center mt-2">
                                    <span class="text-xs font-bold uppercase mr-2">Civil Status:</span>

                                    <div class="flex items-center space-x-2">
                                        <x-checkbox-display :checked="$rsbsa->memberInformation?->isSingle()" />
                                        <span class="text-xs">Single</span>
                                    </div>

                                    <div class="flex items-center space-x-2 ml-4">
                                        <x-checkbox-display :checked="$rsbsa->memberInformation?->isMarried()" />
                                        <span class="text-xs">Married</span>
                                    </div>

                                    <div class="flex items-center space-x-2 ml-4">
                                        <x-checkbox-display :checked="$rsbsa->memberInformation?->isWidowed()" />
                                        <span class="text-xs">Widowed</span>
                                    </div>

                                    <div class="flex items-center space-x-2 ml-4">
                                        <x-checkbox-display :checked="$rsbsa->memberInformation?->isSeparated()" />
                                        <span class="text-xs">Separated</span>
                                    </div>
                                </div>


                                <div class="mt-2 ">
                                    <p class="text-xs font-bold uppercase">Name of Spouse if Married:</p>
                                        <x-display-text value="{{ $rsbsa->memberInformation->spouse ?? '' }}" class="border-b border-black w-full h-6 text-xs italic "/>
                                </div>

                            </div>
                            <div class="col-span-6">

                            </div>

                        </div>
                        <div class="col-span-6 p-2 border-b border-black">
                            <div class=" ">
                                <p class="text-xs font-bold uppercase">Mother's Maiden Name:</p>
                                <x-display-text value="{{ $rsbsa->memberInformation->mother_maiden_name ?? '' }}" class="border-b border-black w-full h-6 text-xs italic "/>
                            </div>

                        </div>

                        <div class="col-span-6">
                            <!-- Household Head Section -->
                            <div class="border-b border-black p-2">
                                <!-- Household Head Question -->
                                <div class="flex items-center">
                                    <span class="text-xs font-bold uppercase mr-2">Household Head?</span>

                                    <div class="flex items-center space-x-2">
                                        <x-checkbox-display :checked="$rsbsa->household_head" />
                                        <span class="text-xs">Yes</span>
                                    </div>

                                    <div class="flex items-center space-x-2 ml-4">
                                        <x-checkbox-display :checked="!$rsbsa->household_head" />
                                        <span class="text-xs">No</span>
                                    </div>
                                </div>


                                <!-- If No, Additional Information -->
                                <div class="mt-2">
                                    <p class="text-xs">If no, name of household head:</p>

                                    <x-display-text value="{{ $rsbsa->household_head_name ?? 'N/A'}}" class="border-b border-black w-full h-6 text-xs italic" />
                                </div>

                                <div class="mt-2">
                                    <p class="text-xs">Relationship:</p>
                                    <x-display-text value="{{ $rsbsa->relationship_with_household_head ?? 'N/A'}}" class="border-b border-black w-full h-6 text-xs italic" />

                                </div>

                                <div class="mt-2">
                                    <p class="text-xs">No. of living household members:</p>
                                    <x-display-text value="{{ $rsbsa->no_of_living_household_members ?? 'N/A'}}" class="border-b border-black w-full h-6 text-xs italic text-center" />

                                </div>

                                <div class="mt-2 flex space-x-8">
                                    <div>
                                        <p class="text-xs">No. of male:</p>
                                        <div class="border-b border-black w-20 h-6 text-xs italic  text-center">{{ $rsbsa->no_of_male ??'N/A' }}</div>
                                        {{-- <x-display-text value="{{ $rsbsa->no_of_male ?? 'N/A'}}" class="border-b border-black w-20 h-6 text-xs italic  text-center" /> --}}

                                    </div>
                                    <div>
                                        <p class="text-xs">No. of female:</p>
                                        <div class="border-b border-black w-20 h-6 text-xs italic text-center ">{{ $rsbsa->no_of_female ??'N/A' }}</div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class=" col-span-6 border-l border-black border-b ">
                        <!-- Highest Formal Education Section -->
                        <div class="border-b border-black p-2">
                            <span class="text-xs font-bold uppercase">Highest Formal Education:</span>

                            <div class="grid grid-cols-3 gap-x-6 gap-y-2 mt-2 text-xs">
                                @foreach(\App\Models\RsbsaRecord::HIGHEST_FORMAL_EDUCATION as $key => $label)
                                    <div class="flex items-center space-x-2">
                                        <x-checkbox-display :checked="$rsbsa->isEducationLevel($key)" />
                                        <span>{{ $label }}</span>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <div class="flex border-b border-black p-2">
                            <span class="text-xs font-bold uppercase">Person With Disability (PWD)</span>
                            <div class="flex items-center space-x-4 ml-6">
                                <div class="flex items-center space-x-2">
                                    <x-checkbox-display :checked="$rsbsa->is_pwd" />
                                    <span class="text-xs">Yes</span>
                                </div>
                                <div class="flex items-center space-x-2">
                                    <x-checkbox-display :checked="!$rsbsa->is_pwd" />
                                    <span class="text-xs">No</span>
                                </div>
                            </div>
                        </div>

                        <div class="border-b border-black p-2">
                            <div class="grid grid-cols-6 ">
                                <span class="text-xs font-bold uppercase col-span-3">4P’s Beneficiary?</span>
                                <div class="flex items-center space-x-4 col-span-3">
                                    <div class="flex items-center space-x-4">
                                        <div class="flex items-center space-x-2">
                                            <x-checkbox-display :checked="$rsbsa->is_4ps_beneficiary" />
                                            <span class="text-xs">Yes</span>
                                        </div>
                                        <div class="flex items-center space-x-2">
                                            <x-checkbox-display :checked="!$rsbsa->is_4ps_beneficiary" />
                                            <span class="text-xs">No</span>
                                        </div>
                                    </div>

                                </div>
                            </div>

                            <div class="grid grid-cols-6 mt-2">
                                <span class="text-xs font-bold uppercase col-span-3">Member of an <span
                                        class="font-bold italic">Indigenous Group</span>?</span>
                                <div class="flex items-center space-x-4 col-span-3">
                                    <div class="flex items-center space-x-4">
                                        <div class="flex items-center space-x-2">
                                            <x-checkbox-display :checked="$rsbsa->is_indigenous_group_member" />
                                            <span class="text-xs">Yes</span>
                                        </div>
                                        <div class="flex items-center space-x-2">
                                            <x-checkbox-display :checked="!$rsbsa->is_indigenous_group_member" />
                                            <span class="text-xs">No</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-2">
                                <p class="text-xs">If yes, specify:</p>
                                {{-- <div class="border-b border-black w-full h-6 text-xs italic text-center">T’boli Tribe
                                </div> --}}
                                <x-display-text value="{{ $rsbsa->indigenous_group_name ?? 'N/A'}}" class="border-b border-black w-full h-6 text-xs italic text-center" />

                            </div>
                        </div>

                        <!-- Government ID Section -->
                        <div class="border-b border-black p-2">
                            <div class="grid grid-cols-6">
                                <span class="text-xs font-bold uppercase col-span-3">With <span
                                        class="font-bold">Government ID?</span></span>
                                <div class="flex items-center space-x-4 col-span-3">
                                    <div class="flex items-center space-x-2">
                                        <x-checkbox-display :checked="$rsbsa->has_government_id" />
                                        <span class="text-xs">Yes</span>
                                    </div>
                                    <div class="flex items-center space-x-2">
                                        <x-checkbox-display :checked="!$rsbsa->has_government_id" />
                                        <span class="text-xs">No</span>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-2">
                                <p class="text-xs">If yes, specify</p>
                            </div>

                            <div class="mt-2">
                                <p class="text-xs font-bold uppercase">ID Type:</p>

                                <x-display-text value="{{ $rsbsa->id_type ?? 'N/A'}}" class="border-b border-black w-full h-6 text-xs italic text-center" />

                            </div>
                            <div class="mt-2">
                                <p class="text-xs font-bold uppercase">ID Number:</p>
                                <x-display-text value="{{ $rsbsa->id_number ?? 'N/A'}}" class="border-b border-black w-full h-6 text-xs italic text-center" />

                            </div>
                        </div>

                        <div class="border-b border-black p-2">
                            <div class="grid grid-cols-6">
                                <span class="text-xs font-bold uppercase col-span-4">Member of any <span
                                        class="font-bold">Farmers Association/Cooperative?</span></span>
                                <div class="flex items-center space-x-4 col-span-2">
                                    <div class="flex items-center space-x-2">
                                        <x-checkbox-display :checked="$rsbsa->is_farmers_association_member" />
                                        <span class="text-xs">Yes</span>
                                    </div>
                                    <div class="flex items-center space-x-2">
                                        <x-checkbox-display :checked="!$rsbsa->is_farmers_association_member" />
                                        <span class="text-xs">No</span>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-2">
                                <p class="text-xs">If yes, specify:</p>
                                <x-display-text value="{{ $rsbsa->farmers_association_name ?? 'N/A'}}" class="border-b border-black w-full h-6 text-xs italic text-center" />

                            </div>
                        </div>

                        <div class=" p-2">
                            <p class="text-xs font-bold uppercase">Person to Notify in Case of Emergency:</p>

                            <x-display-text value="{{ $rsbsa->emergency_contact_name ?? 'N/A'}}" class="border-b border-black w-full h-6 text-xs italic text-center" />


                                @php
                                $emergencyNumber = $rsbsa->getFormattedEmergencyContact();
                            @endphp

                            <p class="text-xs font-bold uppercase mt-2">Contact Number:</p>
                            <div class="flex space-x-1 mt-1">
                                @foreach($emergencyNumber as $digit)
                                    <div class="border border-black w-6 h-6 text-xs italic flex items-center justify-center">
                                        {{ $digit }}
                                    </div>
                                @endforeach
                            </div>

                        </div>




                    </div>

                </div>


            </div>












        </div>




        <div class=" border-black">
            <!-- Section Header -->
            <div class="bg-black text-white font-bold p-1 uppercase">
                Part II: Farm Profile
            </div>

            <!-- Main Livelihood -->
            <div class="grid grid-cols-4 text-xs font-bold border-b border-black p-2">


                @foreach(\App\Models\RsbsaRecord::LIVELIHOOD_OPTION as $key => $label)
                    <div class="flex items-center space-x-2 uppercase">
                        @if ($loop->first)
                        <div class="col-span-4  text-xs font-bold uppercase">Main Livelihood</div>
                        @endif
                        <x-checkbox-display :checked="$rsbsa->hasLivelihood($key)" />
                        <span>{{ $label }}</span>
                    </div>
                @endforeach
            </div>



            <!-- Farm Profile Details -->
            <div class="grid grid-cols-4 border-b border-black text-xs">
                <!-- Farmers -->
                <div class="border-r border-black p-2">
                    <p class="font-bold italic text-center">For farmers:</p>
                    <p class="font-bold mt-2">Type of Farming Activity</p>

                    <div class="space-y-2 mt-2">
                        <!-- Rice -->
                        <div class="flex items-center space-x-2">
                            <x-checkbox-display :checked="$rsbsa->farming_rice" />
                            <span>Rice</span>
                        </div>

                        <!-- Corn -->
                        <div class="flex items-center space-x-2">
                            <x-checkbox-display :checked="$rsbsa->farming_corn" />
                            <span>Corn</span>
                        </div>

                        <!-- Other Crops (Full Width Input) -->
                        <div class="space-y-1">
                            <div class="flex items-center space-x-2">
                                <x-checkbox-display :checked="$rsbsa->other_crops" />
                                <span>Other crops, please specify:</span>
                            </div>
                            <div class="border-b border-black w-full text-xs italic p-1">
                                {{ $rsbsa->other_crops ? $rsbsa->farming_other_crops : '' }}
                            </div>
                        </div>

                        <!-- Livestock (Full Width Input) -->
                        <div class="space-y-1">
                            <div class="flex items-center space-x-2">
                                <x-checkbox-display :checked="$rsbsa->livestock" />
                                <span>Livestock, please specify:</span>
                            </div>
                            <div class="border-b border-black w-full text-xs italic p-1">
                                {{ $rsbsa->livestock ? $rsbsa->farming_livestock : '' }}
                            </div>
                        </div>

                        <!-- Poultry (Full Width Input) -->
                        <div class="space-y-1">
                            <div class="flex items-center space-x-2">
                                <x-checkbox-display :checked="$rsbsa->poultry" />
                                <span>Poultry, please specify:</span>
                            </div>
                            <div class="border-b border-black w-full text-xs italic p-1">
                                {{ $rsbsa->poultry ? $rsbsa->farming_poultry : '' }}
                            </div>
                        </div>
                    </div>
                </div>


                <!-- Farmworkers -->
                <div class="border-r border-black p-2">
                    <p class="font-bold italic text-center">For farmworkers:</p>
                    <p class="font-bold mt-2">Kind of Work</p>

                    <div class="space-y-2 mt-2">
                        <!-- Land Preparation -->
                        <div class="flex items-center space-x-2">
                            <x-checkbox-display :checked="$rsbsa->work_land_preparation" />
                            <span>Land Preparation</span>
                        </div>

                        <!-- Planting/Transplanting -->
                        <div class="flex items-center space-x-2">
                            <x-checkbox-display :checked="$rsbsa->work_planting_transplanting" />
                            <span>Planting/Transplanting</span>
                        </div>

                        <!-- Cultivation -->
                        <div class="flex items-center space-x-2">
                            <x-checkbox-display :checked="$rsbsa->work_cultivation" />
                            <span>Cultivation</span>
                        </div>

                        <!-- Harvesting -->
                        <div class="flex items-center space-x-2">
                            <x-checkbox-display :checked="$rsbsa->work_harvesting" />
                            <span>Harvesting</span>
                        </div>

                        <!-- Other Work (Full Width Input) -->
                        <div class="space-y-1">
                            <div class="flex items-center space-x-2">
                                <x-checkbox-display :checked="$rsbsa->work_others" />
                                <span>Others, please specify:</span>
                            </div>
                            <div class="border-b border-black w-full text-xs italic p-1">
                                {{ $rsbsa->work_others ? $rsbsa->work_others_specify : '' }}
                            </div>
                        </div>
                    </div>
                </div>


                <!-- Fisherfolk -->
                <!-- Fisherfolk -->
                <div class="border-r border-black p-2">
                    <p class="font-bold italic text-center">For fisherfolk:</p>
                    <p class="text-xs italic">
                        The Lending Conduit shall coordinate with the Bureau of Fisheries and
                        Aquatic Resources (<span class="font-bold">BFAR</span>) in the issuance of a certification
                        that the fisherfolk-borrower under <span class="font-bold">PUNLA/PLEA</span> is registered
                        under the Municipal Registration (<span class="font-bold">FishR</span>).
                    </p>
                    <p class="font-bold mt-2">Type of Fishing Activity</p>

                    <div class="space-y-2 mt-2">
                        <!-- Fish Capture -->
                        <div class="flex items-center space-x-2">
                            <x-checkbox-display :checked="$rsbsa->fishing_fish_capture" />
                            <span>Fish Capture</span>
                        </div>

                        <!-- Fish Processing -->
                        <div class="flex items-center space-x-2">
                            <x-checkbox-display :checked="$rsbsa->fishing_fish_processing" />
                            <span>Fish Processing</span>
                        </div>

                        <!-- Aquaculture -->
                        <div class="flex items-center space-x-2">
                            <x-checkbox-display :checked="$rsbsa->fishing_aquaculture" />
                            <span>Aquaculture</span>
                        </div>

                        <!-- Fish Vending -->
                        <div class="flex items-center space-x-2">
                            <x-checkbox-display :checked="$rsbsa->fishing_fish_vending" />
                            <span>Fish Vending</span>
                        </div>

                        <!-- Gleaning -->
                        <div class="flex items-center space-x-2">
                            <x-checkbox-display :checked="$rsbsa->fishing_gleaning" />
                            <span>Gleaning</span>
                        </div>

                        <!-- Other Fishing Activity (Full Width Input) -->
                        <div class="space-y-1">
                            <div class="flex items-center space-x-2">
                                <x-checkbox-display :checked="$rsbsa->fishing_others" />
                                <span>Others, please specify:</span>
                            </div>
                            <div class="border-b border-black w-full text-xs italic p-1">
                                {{ $rsbsa->fishing_others ? $rsbsa->fishing_others_specify : '' }}
                            </div>
                        </div>
                    </div>
                </div>



                <!-- Agri Youth -->
                <div class="p-2">
                    <p class="font-bold italic text-center">For Agri Youth:</p>
                    <p class="text-xs italic">
                        For the purposes of trainings, financial assistance, and other programs
                        catered to the youth with involvement in any agricultural activity.
                    </p>
                    <p class="font-bold mt-2">Type of Involvement</p>

                    <div class="space-y-2 mt-2">
                        <!-- Part of a Farming Household -->
                        <div class="flex items-center space-x-2">
                            <x-checkbox-display :checked="$rsbsa->youth_farming_household" />
                            <span>Part of a farming household</span>
                        </div>

                        <!-- Attended Formal Agri-Fishery Course -->
                        <div class="flex items-center space-x-2">
                            <x-checkbox-display :checked="$rsbsa->youth_agri_course" />
                            <span>Attended formal agri-fishery course</span>
                        </div>

                        <!-- Attended Non-Formal Agri-Fishery Course -->
                        <div class="flex items-center space-x-2">
                            <x-checkbox-display :checked="$rsbsa->youth_nonformal_agri_course" />
                            <span>Attended non-formal agri-fishery course</span>
                        </div>

                        <!-- Participated in Any Agricultural Program -->
                        <div class="flex items-center space-x-2">
                            <x-checkbox-display :checked="$rsbsa->youth_agri_program" />
                            <span>Participated in any agricultural program</span>
                        </div>

                        <!-- Other (Full Width Input) -->
                        <div class="space-y-1">
                            <div class="flex items-center space-x-2">
                                <x-checkbox-display :checked="$rsbsa->youth_others" />
                                <span>Others, please specify:</span>
                            </div>
                            <div class="border-b border-black w-full text-xs italic p-1">
                                {{ $rsbsa->youth_others ? $rsbsa->youth_others_specify : '' }}
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <div class="p-2 flex justify-between items-center">
                <span class="text-xs font-bold uppercase">Gross Annual Income Last Year:</span>
                <div class="flex items-center space-x-4">
                    <span class="text-xs">Farming:</span>
                    <x-display-text
                        value="₱{{ number_format($rsbsa->gross_annual_income_farming ?? 0, 2) }}"
                        class="border-b border-black w-40 h-5 text-xs italic text-center"
                    />

                    <span class="text-xs">Non-farming:</span>
                    <x-display-text
                        value="₱{{ number_format($rsbsa->gross_annual_income_nonfarming ?? 0, 2) }}"
                        class="border-b border-black w-40 h-5 text-xs italic text-center"
                    />
                </div>
            </div>


        </div>


    </div>
    <div class="relative  border-black h-8">
        <div
            class="absolute left-0 right-0 top-1/2 transform -translate-y-1/2 border-t border-dashed border-black w-full border-spacing-[7px] ">
        </div>
        <i class="fas fa-cut absolute right-0 top-1/2 transform -translate-y-1/2 rotate-180  text-xl bg-white"></i>
    </div>

    <div class="border border-black">
        <div class="">


            <div class="text-center p-2 ">
                <h1 class="text-lg font-bold ">Registry System for Basic Sectors in Agriculture (RSBSA)</h1>
                <h2 class="text-lg font-bold uppercase">Enrollment Client’s Copy</h2>
            </div>


            <div class="flex mt-4 p-2">
                <p class="font-semibold italic text-xs mr-4 min-w-[160px]">Reference Number:</p>
                <div class="flex space-x-2">
                    <!-- Region -->
                    <div class="flex flex-col">
                        <div class="flex border border-black">
                            @foreach ($codes['region'] as $index => $digit)
                                <div
                                    class="w-6 h-6 flex items-center justify-center text-xs {{ $loop->last ? '' : 'border-r border-black' }}">
                                    {{ $digit }}
                                </div>
                            @endforeach
                        </div>
                        <span class="uppercase text-xs text-center mt-1">Region</span>
                    </div>

                    <!-- Province -->
                    <div class="flex flex-col">
                        <div class="flex border border-black">
                            @foreach ($codes['province'] as $index => $digit)
                                <div
                                    class="w-6 h-6 flex items-center justify-center text-xs {{ $loop->last ? '' : 'border-r border-black' }}">
                                    {{ $digit }}
                                </div>
                            @endforeach
                        </div>
                        <span class="uppercase text-xs text-center mt-1">Province</span>
                    </div>

                    <!-- City/Municipality -->
                    <div class="flex flex-col">
                        <div class="flex border border-black">
                            @foreach ($codes['city_municipality'] as $index => $digit)
                                <div
                                    class="w-6 h-6 flex items-center justify-center text-xs {{ $loop->last ? '' : 'border-r border-black' }}">
                                    {{ $digit }}
                                </div>
                            @endforeach
                        </div>
                        <span class="uppercase text-xs text-center mt-1">City/Muni</span>
                    </div>

                    <!-- Barangay -->
                    <div class="flex flex-col">
                        <div class="flex border border-black">
                            @foreach ($codes['barangay'] as $index => $digit)
                                <div
                                    class="w-6 h-6 flex items-center justify-center text-xs {{ $loop->last ? '' : 'border-r border-black' }}">
                                    {{ $digit }}
                                </div>
                            @endforeach
                        </div>
                        <span class="uppercase text-xs text-center mt-1">Barangay</span>
                    </div>

                    <!-- Last 6 Digits (Always Exists) -->
                    <div class="flex flex-col">
                        <div class="flex border border-black">
                            @foreach ($codes['last_six'] as $index => $digit)
                                <div
                                    class="w-6 h-6 flex items-center justify-center text-xs {{ $loop->last ? '' : 'border-r border-black' }}">

                                </div>
                            @endforeach
                        </div>
                        <span class="uppercase text-xs text-center mt-1 invisible">""</span>
                    </div>
                </div>
            </div>

            <div class="col-span-12">

                    <div class="grid grid-cols-2">
                        <div class="p-2">
                            <x-display-text value="{{ $rsbsa->memberinformation?->user?->surname ?? 'N/A' }}"
                                class="text-center" />

                            <div class="text-center text-xs font-bold uppercase border-t border-black ">Surname</div>
                        </div>
                        <div class="p-2">
                            <x-display-text value="{{ $rsbsa->memberinformation?->user?->surname ?? 'N/A' }}"
                                class="text-center" />
                            <div class="text-center text-xs font-bold uppercase border-t border-black ">First Name</div>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 ">
                        <div class="p-2">
                            <x-display-text value="{{ $rsbsa->memberinformation?->user?->middle_name ?? 'N/A' }}"
                                class="text-center" />
                            <div class="text-center text-xs font-bold uppercase border-t border-black ">Middle Name
                            </div>
                        </div>
                        <div class="grid grid-cols-2">
                            <div class="p-2">

                                <x-display-text value="{{ $rsbsa->extension_name }}" class="text-center" />

                                <div class="text-center text-xs font-bold uppercase border-t border-black ">Extension
                                    Name
                                </div>
                            </div>
                            <div
                                class="inline-flex items-center justify-center border-l-2 border-t-2  border-black p-2">
                                <div class="text-xs font-bold uppercase">Sex:</div>
                                <div class="flex items-center space-x-2 ml-2">
                                    <x-checkbox-display
                                        checked="{{ $rsbsa->memberinformation?->gender?->name === 'Male' }}" />

                                    <span class="text-xs">Male</span>
                                </div>
                                <div class="flex items-center space-x-2 ml-4">
                                    <x-checkbox-display
                                        checked="{{ $rsbsa->memberinformation?->gender?->name === 'Female' }}" />
                                    <span class="text-xs">Female</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
        </div>

        <!-- Footer Text -->

    </div>
    <div class="text-center p-2  font-bold  ">
        This form is not for sale
    </div>
    <div class="mt-2 grid grid-cols-12">
        <div class="border border-black  text-xs col-span-12">
            <!-- Header Row -->
            <div class="grid grid-cols-5 gap-x-2 border-b border-black p-1 font-bold uppercase">
                <div>No. of Farm Parcels: <span class="italic font-normal">3</span></div>
                <div>Name of Farmer’s in Rotation: </div>
                <div class="border-b border-black">(P1) <span class="italic font-normal  ">Juan Dela Cruz</span></div>
                <div class="border-b border-black">(P2) <span class="italic font-normal  ">Juan Dela Cruz</span></div>
                <div class="border-b border-black">(P3) <span class="italic font-normal  ">Juan Dela Cruz</span></div>
            </div>

            <!-- Table Headers -->
            <div class="grid grid-cols-10 border-b border-black font-bold text-center uppercase">
                <div class="col-span-1 p-2 border-r border-black">Farm Parcel No.</div>
                <div class="col-span-3 p-2 border-r border-black">Farm Land Description</div>
                <div class="col-span-1 p-2 border-r border-black ">
                    CROP/COMMODITY
                    <p class="italic font-normal break-words">(Rice/Corn/HVC/Livestock/Poultry/Agri-fishery)</p>
                    <p class="mt-2 font-bold">For Livestock & Poultry</p>
                    <p class="italic font-normal">(specify type of animal)</p>
                </div>
                <div class="col-span-1 p-2 border-r border-black">Size (ha)</div>
                <div class="col-span-1 p-2 border-r border-black">
                    <p class="mt-2 font-bold"> No. of Head</p>
                    <p class="italic font-normal break-words">(For Livestock and Poultry)</p>
                </div>
                <div class="col-span-1 p-2 border-r border-black">Farm Type **</div>
                <div class="col-span-1 p-2 border-r border-black">Organic Practitioner (Y/N)</div>
                <div class="col-span-1 p-2">Remarks</div>
            </div>

            <!-- Farm Parcel 1 -->
            <div class="grid grid-cols-10 border-b border-black text-xs">
                <div class="col-span-1 p-2 border-r border-black text-center">1</div>
                <div class="col-span-3 p-2 border-r border-black">
                    <div class="">
                        <!-- Farm Location -->
                        <span class="text-xs font-bold ">Farm Location:</span>
                        <div class="mt-2">
                            <div class="border-b border-black w-full text-xs italic text-center">Poblacion</div>
                            <p class="text-center text-xs font-bold ">Barangay</p>
                        </div>
                        <div class="mt-2">
                            <div class="border-b border-black w-full text-xs italic text-center">Isulan</div>
                            <p class="text-center text-xs font-bold ">City/Municipality</p>
                        </div>
                    </div>

                    <!-- Total Farm Area & Ownership -->
                    <div class="border-b border-black p-2">
                        <div class="flex justify-between">
                            <span class="text-xs font-bold ">Total Farm Area (in hectares):</span>
                            <div class="border-b border-black w-20 text-xs italic text-center">3.5</div>
                            <span class="text-xs font-bold  ml-2">ha</span>
                        </div>

                        <div class="flex justify-between mt-2">
                            <span class="text-xs font-bold ">Ownership Document No*:</span>
                            <div class="border-b border-black w-32 text-xs italic text-center">123456</div>
                        </div>
                    </div>

                    <!-- Ancestral Domain & Agrarian Reform -->
                    <div class="border-b border-black p-2">
                        <div class="flex justify-between">
                            <div class="flex items-center space-x-2">
                                <span class="text-xs font-bold ">Within Ancestral Domain:</span>
                                <div class="flex items-center space-x-2 ml-2">
                                    <div class="border border-black w-4 h-4"></div>
                                    <span class="text-xs">Yes</span>
                                </div>
                                <div class="flex items-center space-x-2 ml-4">
                                    <div class="border border-black w-4 h-4 flex items-center justify-center">&#10003;
                                    </div>
                                    <span class="text-xs">No</span>
                                </div>
                            </div>

                            <div class="flex items-center space-x-2">
                                <span class="text-xs font-bold uppercase">Agrarian Reform Beneficiary:</span>
                                <div class="flex items-center space-x-2 ml-2">
                                    <div class="border border-black w-4 h-4"></div>
                                    <span class="text-xs">Yes</span>
                                </div>
                                <div class="flex items-center space-x-2 ml-4">
                                    <div class="border border-black w-4 h-4 flex items-center justify-center">&#10003;
                                    </div>
                                    <span class="text-xs">No</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Ownership Type -->
                    <div class="border-b border-black p-2">
                        <span class="text-xs font-bold uppercase">Ownership Type:</span>
                        <div class="grid grid-cols-2 gap-x-4 mt-2 text-xs">
                            <div class="flex items-center space-x-2">
                                <div class="border border-black w-4 h-4 flex items-center justify-center">&#10003;
                                </div>
                                <span>Registered Owner</span>
                            </div>
                            <div class="flex items-center space-x-2">
                                <div class="border border-black w-4 h-4"></div>
                                <span>Others:</span>
                                <div class="border-b border-black w-full italic text-center">Corporate Ownership</div>
                            </div>
                            <div class="flex items-center space-x-2 col-span-2">
                                <div class="border border-black w-4 h-4"></div>
                                <span>Tenant (Name of Land Owner: </span>
                                <div class="border-b border-black flex-grow italic text-center">Juan Dela Cruz</div>
                                <span>)</span>
                            </div>
                            <div class="flex items-center space-x-2 col-span-2">
                                <div class="border border-black w-4 h-4"></div>
                                <span>Lessee (Name of Land Owner: </span>
                                <div class="border-b border-black flex-grow italic text-center">Maria Santos</div>
                                <span>)</span>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="col-span-1 p-2 border-r border-black text-center">Rice</div>
                <div class="col-span-1 p-2 border-r border-black text-center">3.5</div>
                <div class="col-span-1 p-2 border-r border-black text-center">-</div>
                <div class="col-span-1 p-2 border-r border-black text-center">1</div>
                <div class="col-span-1 p-2 border-r border-black text-center">No</div>
                <div class="col-span-1 p-2 text-center">Good condition</div>
            </div>

            <!-- Farm Parcel 2 -->
            <div class="grid grid-cols-10 border-b border-black text-xs">
                <div class="col-span-1 p-2 border-r border-black text-center">2</div>
                <div class="col-span-3 p-2 border-r border-black">
                    <div class="">
                        <!-- Farm Location -->
                        <span class="text-xs font-bold ">Farm Location:</span>
                        <div class="mt-2">
                            <div class="border-b border-black w-full text-xs italic text-center">Poblacion</div>
                            <p class="text-center text-xs font-bold ">Barangay</p>
                        </div>
                        <div class="mt-2">
                            <div class="border-b border-black w-full text-xs italic text-center">Isulan</div>
                            <p class="text-center text-xs font-bold ">City/Municipality</p>
                        </div>
                    </div>

                    <!-- Total Farm Area & Ownership -->
                    <div class="border-b border-black p-2">
                        <div class="flex justify-between">
                            <span class="text-xs font-bold ">Total Farm Area (in hectares):</span>
                            <div class="border-b border-black w-20 text-xs italic text-center">3.5</div>
                            <span class="text-xs font-bold  ml-2">ha</span>
                        </div>

                        <div class="flex justify-between mt-2">
                            <span class="text-xs font-bold ">Ownership Document No*:</span>
                            <div class="border-b border-black w-32 text-xs italic text-center">123456</div>
                        </div>
                    </div>

                    <!-- Ancestral Domain & Agrarian Reform -->
                    <div class="border-b border-black p-2">
                        <div class="flex justify-between">
                            <div class="flex items-center space-x-2">
                                <span class="text-xs font-bold ">Within Ancestral Domain:</span>
                                <div class="flex items-center space-x-2 ml-2">
                                    <div class="border border-black w-4 h-4"></div>
                                    <span class="text-xs">Yes</span>
                                </div>
                                <div class="flex items-center space-x-2 ml-4">
                                    <div class="border border-black w-4 h-4 flex items-center justify-center">&#10003;
                                    </div>
                                    <span class="text-xs">No</span>
                                </div>
                            </div>

                            <div class="flex items-center space-x-2">
                                <span class="text-xs font-bold uppercase">Agrarian Reform Beneficiary:</span>
                                <div class="flex items-center space-x-2 ml-2">
                                    <div class="border border-black w-4 h-4"></div>
                                    <span class="text-xs">Yes</span>
                                </div>
                                <div class="flex items-center space-x-2 ml-4">
                                    <div class="border border-black w-4 h-4 flex items-center justify-center">&#10003;
                                    </div>
                                    <span class="text-xs">No</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Ownership Type -->
                    <div class="border-b border-black p-2">
                        <span class="text-xs font-bold uppercase">Ownership Type:</span>
                        <div class="grid grid-cols-2 gap-x-4 mt-2 text-xs">
                            <div class="flex items-center space-x-2">
                                <div class="border border-black w-4 h-4 flex items-center justify-center">&#10003;
                                </div>
                                <span>Registered Owner</span>
                            </div>
                            <div class="flex items-center space-x-2">
                                <div class="border border-black w-4 h-4"></div>
                                <span>Others:</span>
                                <div class="border-b border-black w-full italic text-center">Corporate Ownership</div>
                            </div>
                            <div class="flex items-center space-x-2 col-span-2">
                                <div class="border border-black w-4 h-4"></div>
                                <span>Tenant (Name of Land Owner: </span>
                                <div class="border-b border-black flex-grow italic text-center">Juan Dela Cruz</div>
                                <span>)</span>
                            </div>
                            <div class="flex items-center space-x-2 col-span-2">
                                <div class="border border-black w-4 h-4"></div>
                                <span>Lessee (Name of Land Owner: </span>
                                <div class="border-b border-black flex-grow italic text-center">Maria Santos</div>
                                <span>)</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-span-1 p-2 border-r border-black text-center">Corn</div>
                <div class="col-span-1 p-2 border-r border-black text-center">5.0</div>
                <div class="col-span-1 p-2 border-r border-black text-center">-</div>
                <div class="col-span-1 p-2 border-r border-black text-center">2</div>
                <div class="col-span-1 p-2 border-r border-black text-center">Yes</div>
                <div class="col-span-1 p-2 text-center">Needs irrigation</div>
            </div>

            <!-- Farm Parcel 3 -->
            <div class="grid grid-cols-10 border-b border-black text-xs">
                <div class="col-span-1 p-2 border-r border-black text-center">3</div>
                <div class="col-span-3 p-2 border-r border-black">
                    <div class="">
                        <!-- Farm Location -->
                        <span class="text-xs font-bold ">Farm Location:</span>
                        <div class="mt-2">
                            <div class="border-b border-black w-full text-xs italic text-center">Poblacion</div>
                            <p class="text-center text-xs font-bold ">Barangay</p>
                        </div>
                        <div class="mt-2">
                            <div class="border-b border-black w-full text-xs italic text-center">Isulan</div>
                            <p class="text-center text-xs font-bold ">City/Municipality</p>
                        </div>
                    </div>

                    <!-- Total Farm Area & Ownership -->
                    <div class="border-b border-black p-2">
                        <div class="flex justify-between">
                            <span class="text-xs font-bold ">Total Farm Area (in hectares):</span>
                            <div class="border-b border-black w-20 text-xs italic text-center">3.5</div>
                            <span class="text-xs font-bold  ml-2">ha</span>
                        </div>

                        <div class="flex justify-between mt-2">
                            <span class="text-xs font-bold ">Ownership Document No*:</span>
                            <div class="border-b border-black w-32 text-xs italic text-center">123456</div>
                        </div>
                    </div>

                    <!-- Ancestral Domain & Agrarian Reform -->
                    <div class="border-b border-black p-2">
                        <div class="flex justify-between">
                            <div class="flex items-center space-x-2">
                                <span class="text-xs font-bold ">Within Ancestral Domain:</span>
                                <div class="flex items-center space-x-2 ml-2">
                                    <div class="border border-black w-4 h-4"></div>
                                    <span class="text-xs">Yes</span>
                                </div>
                                <div class="flex items-center space-x-2 ml-4">
                                    <div class="border border-black w-4 h-4 flex items-center justify-center">&#10003;
                                    </div>
                                    <span class="text-xs">No</span>
                                </div>
                            </div>

                            <div class="flex items-center space-x-2">
                                <span class="text-xs font-bold uppercase">Agrarian Reform Beneficiary:</span>
                                <div class="flex items-center space-x-2 ml-2">
                                    <div class="border border-black w-4 h-4"></div>
                                    <span class="text-xs">Yes</span>
                                </div>
                                <div class="flex items-center space-x-2 ml-4">
                                    <div class="border border-black w-4 h-4 flex items-center justify-center">&#10003;
                                    </div>
                                    <span class="text-xs">No</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Ownership Type -->
                    <div class="border-b border-black p-2">
                        <span class="text-xs font-bold uppercase">Ownership Type:</span>
                        <div class="grid grid-cols-2 gap-x-4 mt-2 text-xs">
                            <div class="flex items-center space-x-2">
                                <div class="border border-black w-4 h-4 flex items-center justify-center">&#10003;
                                </div>
                                <span>Registered Owner</span>
                            </div>
                            <div class="flex items-center space-x-2">
                                <div class="border border-black w-4 h-4"></div>
                                <span>Others:</span>
                                <div class="border-b border-black w-full italic text-center">Corporate Ownership</div>
                            </div>
                            <div class="flex items-center space-x-2 col-span-2">
                                <div class="border border-black w-4 h-4"></div>
                                <span>Tenant (Name of Land Owner: </span>
                                <div class="border-b border-black flex-grow italic text-center">Juan Dela Cruz</div>
                                <span>)</span>
                            </div>
                            <div class="flex items-center space-x-2 col-span-2">
                                <div class="border border-black w-4 h-4"></div>
                                <span>Lessee (Name of Land Owner: </span>
                                <div class="border-b border-black flex-grow italic text-center">Maria Santos</div>
                                <span>)</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-span-1 p-2 border-r border-black text-center">Vegetables</div>
                <div class="col-span-1 p-2 border-r border-black text-center">2.8</div>
                <div class="col-span-1 p-2 border-r border-black text-center">-</div>
                <div class="col-span-1 p-2 border-r border-black text-center">3</div>
                <div class="col-span-1 p-2 border-r border-black text-center">No</div>
                <div class="col-span-1 p-2 text-center">Flood-prone</div>
            </div>


            <!-- Ownership Document and Farm Type -->
            <div class=" border-black grid grid-cols-3 text-xs p-2">
                <!-- Ownership Document -->
                <div class="col-span-2">
                    <p class="font-bold uppercase text-lg ">Ownership Document *</p>
                    <div class="grid grid-cols-2">
                        <div>
                            <p>1. Certificate of Land Transfer</p>
                            <p>2. Emancipation Patent</p>
                            <p>3. Individual Certificate of Land Ownership Award (CLOA)</p>
                            <p>4. Collective CLOA</p>
                            <p>5. Co-ownership CLOA</p>
                        </div>
                        <div>
                            <p>6. Agricultural Sales Patent</p>
                            <p>7. Homestead Patent</p>
                            <p>8. Free Patent</p>
                            <p>9. Certificate of Title or Regular Title</p>
                            <p>10. Certificate of Ancestral Domain Title</p>
                            <p>11. Certificate of Ancestral Land Title</p>
                            <p>12. Tax Declaration</p>
                            <p>13. Others (e.g., Barangay Certification)</p>
                        </div>
                    </div>
                </div>

                <!-- Farm Type -->
                <div class="col-span-1">
                    <p class="font-bold uppercase text-lg">Farm Type **</p>
                    <p>1 - Irrigated</p>
                    <p>2 - Rainfed Upland</p>
                    <p>3 - Rainfed Lowland</p>
                    <p class="italic text-sm ">(NOTE: no to agri-fishery)</p>
                </div>
            </div>
            <div class="border-t-2 border-black  p-2 text-xs ">
                I hereby declare that all information indicated above are true and correct, and that they may be
                used by the
                Department of Agriculture for the purposes of registration to the Registry System for Basic Sectors
                in
                Agriculture (RSBSA) and other legitimate interests of the Department pursuant to its mandates.
            </div>
            <div class="grid grid-cols-4 border-t-2 border-black text-xs text-center">
                <!-- Date Field -->


                <!-- Printed Name of Applicant -->
                <div class="border-r border-black">
                    <div class="w-full h-24 border-b border-black"></div>
                    <p class="bg-black text-white font-bold uppercase p-1">Date</p>
                </div>
                <div class="border-r border-black">
                    <div class="w-full h-24 border-b border-black"></div>
                    <p class="bg-black text-white font-bold uppercase p-1">Printed Name of Applicant</p>
                </div>

                <!-- Signature of Applicant -->
                <div class="border-r border-black">
                    <div class="w-full h-24 border-b border-black"></div>
                    <p class="bg-black text-white font-bold uppercase p-1">Signature of Applicant</p>
                </div>

                <!-- Thumbmark -->
                <div>
                    <div class="w-full h-24 border-b border-black"></div>
                    <p class="bg-black text-white font-bold uppercase p-1">Thumbmark</p>
                </div>
            </div>


            <!-- Footer Section -->
            <div class="border-t-2 border-black p-2  uppercase">
                <p class="font-bold">Verified True and Correct By:</p>
                <div class="grid grid-cols-3 text-center mt-2">
                    <!-- Barangay Chairman -->
                    <div class="p-2 leading-none">
                        <div class="border-b border-black w-full h-6"></div>
                        <p class="text-[10px] uppercase mt-1">Signature Above Printed Name / Date</p>
                        <p class="font-bold uppercase mt-1 ">Barangay Chairman / City / Mun. Veterinarian (Livestock) /
                            Mill District Officer (Sugarcane) / IP Leader / C/M-PARO (ARB)</p>
                    </div>
                    <!-- City/Municipal Agriculture Office -->
                    <div class="p-2 leading-none">
                        <div class="border-b border-black w-full h-6"></div>
                        <p class="text-[10px] uppercase mt-1">Signature Above Printed Name / Date</p>
                        <p class="font-bold uppercase mt-1 ">City/Municipal Agriculture Office</p>
                    </div>
                    <!-- CAFC/MAFC Chairman -->
                    <div class="p-2 leading-none">
                        <div class="border-b border-black w-full h-6"></div>
                        <p class="text-[10px] uppercase mt-1">Signature Above Printed Name / Date</p>
                        <p class="font-bold uppercase mt-1 ">CAFC/MAFC Chairman</p>
                    </div>
                </div>
            </div>


            <!-- Data Privacy Policy -->


            <!-- Declaration -->


            <!-- Signature Section -->

            <div class="">
                <div class="bg-black text-white text-xs font-bold p-2 uppercase text-center">
                    Data Privacy Policy
                </div>
                <div class="p-3 text-xs leading-relaxed">
                    <p>
                        The collection of personal information is for documentation, planning, reporting, and processing
                        purposes in availing agricultural-related interventions.
                        Processed data shall only be shared with partner agencies for planning, reporting, and other use
                        in accordance with the mandate of the agency.
                        This is in compliance with the Data Sharing Policy of the department.
                    </p>
                    <p class="mt-2">
                        You have the right to ask for a copy of your personal data that we hold about you as well as to
                        ask for it to be corrected if you think it is wrong.
                        To do so, please contact <span class="italic">&lt;Contact Person and Contact
                            Details&gt;</span>.
                    </p>
                </div>
            </div>

        </div>
    </div>



    <div class="text-center p-2  font-bold  uppercase ">
        This form is not for sale
    </div>

    <div class="border border-black p-2 text-xs font-bold uppercase">
        <p>Verified True and Correct By:</p>
        <div class="grid grid-cols-3 text-center mt-4">
            <!-- Barangay Chairman -->
            <div class="p-4">
                <div class="h-12 border-b border-black"></div>
                <p class="uppercase text-xs font-bold mt-1">Signature Above Printed Name / Date</p>
                <p class="text-xs leading-tight mt-1">
                    Barangay Chairman / City / Mun. Veterinarian (Livestock) /
                    Mill District Officer (Sugarcane) / IP Leader / C/M/Paro (ARB)
                </p>
            </div>

            <!-- City / Municipal Agriculture Office -->
            <div class="p-4">
                <div class="h-12 border-b border-black"></div>
                <p class="uppercase text-xs font-bold mt-1">Signature Above Printed Name / Date</p>
                <p class="uppercase text-xs font-bold">City/Municipal Agriculture Office</p>
            </div>

            <!-- CAFC / MAFC Chairman -->
            <div class="p-4">
                <div class="h-12 border-b border-black"></div>
                <p class="uppercase text-xs font-bold mt-1">Signature Above Printed Name / Date</p>
                <p class="uppercase text-xs font-bold">CAFC/MAFC Chairman</p>
            </div>
        </div>
    </div>


</div>




</div>
