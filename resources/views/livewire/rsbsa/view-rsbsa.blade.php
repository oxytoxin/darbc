<style>
    /* Base print styles */
    @page {
        size: A4 portrait;
        margin: 4mm;
    }

    .rsbsa-form {
        font-family: Arial, sans-serif;
        font-size: 11px;
        line-height: 1.25;
        color: #000;
    }

    .rsbsa-form * {
        box-sizing: border-box;
    }

    /* Checkbox styling */
    .chk {
        width: 11px;
        height: 11px;
        border: 1px solid #000;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 10px;
        vertical-align: middle;
        margin-right: 2px;
    }

    .chk.checked::after {
        content: "✓";
        font-weight: bold;
    }

    /* Input box styling */
    .input-box {
        border-bottom: 1px solid #000;
        min-height: 14px;
        display: inline-block;
    }

    /* Digit box styling */
    .digit-box {
        width: 14px;
        height: 14px;
        border: 1px solid #000;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 10px;
    }

    .digit-box+.digit-box {
        border-left: none;
    }

    /* Section header */
    .section-header {
        background: #000;
        color: #fff;
        font-weight: bold;
        padding: 2px 4px;
        font-size: 11px;
    }

    /* Table styles */
    .form-table {
        width: 100%;
        border-collapse: collapse;
    }

    .form-table td,
    .form-table th {
        border: 1px solid #000;
        padding: 2px 3px;
        vertical-align: top;
    }

    @media print {
        * {
            -webkit-print-color-adjust: exact !important;
            print-color-adjust: exact !important;
        }

        .print-hidden {
            display: none !important;
        }

        .page-break {
            page-break-before: always !important;
            break-before: page !important;
        }

        .no-break {
            page-break-inside: avoid !important;
            break-inside: avoid !important;
        }

        .rsbsa-form {
            width: 200mm;
            margin: 0 auto;
        }

        .bg-black {
            background-color: #000 !important;
        }
    }
</style>

<div class="rsbsa-form max-w-4xl mx-auto">
    <!-- Print Button -->
    <div class="print-hidden mb-4 flex justify-between items-center p-4">
        <a href="{{ route('rsbsa.manage-members') }}"
            class="inline-flex items-center px-4 py-2 bg-gray-500 hover:bg-gray-600 text-white font-semibold rounded-lg shadow">
            ← Back
        </a>
        <button onclick="window.print()"
            class="inline-flex items-center px-4 py-2 bg-primary-600 hover:bg-primary-700 text-white font-semibold rounded-lg shadow">
            Print RSBSA Form
        </button>
    </div>

    <!-- ==================== PAGE 1 ==================== -->
    <div class="page-1 no-break">
        <!-- Version -->
        <div style="text-align: right; font-size: 9px; font-weight: bold;">REVISED VERSION: 03-2021</div>

        <!-- Main Form Border -->
        <div style="border: 2px solid #000;">
            <!-- Header Section -->
            <div style="display: flex; border-bottom: 2px solid #000;">
                <!-- Left: Logo and Title -->
                <div style="flex: 1; padding: 4px; border-right: 2px solid #000;">
                    <div style="display: flex; align-items: flex-start;">
                        <img src="{{ asset('assets/darbc-logo.svg') }}" alt="DA Logo"
                            style="width: 40px; height: 40px; margin-right: 8px;">
                        <div>
                            <div style="font-size: 16px; font-weight: bold; line-height: 1.1;">ANI AT KITA<br>RSBSA
                                ENROLLMENT FORM</div>
                            <div style="font-size: 9px; font-weight: bold;">REGISTRY SYSTEM FOR BASIC SECTORS IN
                                AGRICULTURE (RSBSA)</div>
                        </div>
                    </div>

                    <!-- Enrollment Type & Date -->
                    <div style="display: flex; align-items: center; margin-top: 4px; font-size: 8px;">
                        <span style="font-weight: bold; width: 100px;">ENROLLMENT TYPE &<br>DATE ADMINISTERED:</span>
                        <span class="chk {{ $rsbsa->isNew() ? 'checked' : '' }}"></span> <span
                            style="margin: 0 4px;">New</span>
                        <span class="chk {{ $rsbsa->isUpdating() ? 'checked' : '' }}"></span> <span
                            style="margin: 0 8px;">Updating</span>

                        @php $dateDigits = $rsbsa->getFormattedUpdatedAt(); @endphp
                        <div style="display: flex;">
                            @foreach ($dateDigits as $d)
                                <div class="digit-box">{{ $d }}</div>
                            @endforeach
                        </div>
                    </div>
                    <div style="font-size: 8px; margin-left: 160px;">
                        <span style="margin-left: 4px;">M</span><span style="margin-left: 10px;">M</span>
                        <span style="margin-left: 10px;">D</span><span style="margin-left: 10px;">D</span>
                        <span style="margin-left: 10px;">Y</span><span style="margin-left: 10px;">Y</span>
                        <span style="margin-left: 10px;">Y</span><span style="margin-left: 10px;">Y</span>
                    </div>

                    <!-- Reference Number -->
                    @php $codes = $rsbsa->getFormattedLocationCodes(); @endphp
                    <div style="display: flex; align-items: center; margin-top: 4px; font-size: 8px;">
                        <span style="font-style: italic; font-weight: 600; width: 80px;">Reference Number:</span>
                        <div style="display: flex; gap: 4px;">
                            <div>
                                <div style="display: flex;">
                                    @foreach ($codes['region'] as $d)
                                        <div class="digit-box">{{ $d }}</div>
                                    @endforeach
                                </div>
                                <div style="text-align: center; font-size: 8px;">REGION</div>
                            </div>
                            <div>
                                <div style="display: flex;">
                                    @foreach ($codes['province'] as $d)
                                        <div class="digit-box">{{ $d }}</div>
                                    @endforeach
                                </div>
                                <div style="text-align: center; font-size: 8px;">PROVINCE</div>
                            </div>
                            <div>
                                <div style="display: flex;">
                                    @foreach ($codes['city_municipality'] as $d)
                                        <div class="digit-box">{{ $d }}</div>
                                    @endforeach
                                </div>
                                <div style="text-align: center; font-size: 8px;">CITY/MUNI</div>
                            </div>
                            <div>
                                <div style="display: flex;">
                                    @foreach ($codes['barangay'] as $d)
                                        <div class="digit-box">{{ $d }}</div>
                                    @endforeach
                                </div>
                                <div style="text-align: center; font-size: 8px;">BARANGAY</div>
                            </div>
                            <div>
                                <div style="display: flex;">
                                    @for ($i = 0; $i < 6; $i++)
                                        <div class="digit-box"></div>
                                    @endfor
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right: 2x2 Photo -->
                <div
                    style="width: 90px; display: flex; flex-direction: column; align-items: center; justify-content: center; padding: 4px;">
                    <div style="font-size: 8px; font-weight: bold; text-align: center;">2x2<br>PICTURE</div>
                    <img src="{{ $rsbsa->getImage() }}"
                        style="width: 60px; height: 60px; border: 1px solid #000; object-fit: cover; margin-top: 2px;">
                    <div style="font-size: 8px; text-align: center; margin-top: 2px;">PHOTO TAKEN<br>WITHIN 6 MONTHS
                    </div>
                </div>
            </div>

            <!-- PART I: PERSONAL INFORMATION -->
            <div class="section-header">PART I: PERSONAL INFORMATION</div>

            <!-- Name Row -->
            <div style="display: flex; border-bottom: 1px solid #000;">
                <div style="flex: 1; padding: 2px 4px; border-right: 1px solid #000;">
                    <div style="min-height: 14px; font-weight: 500; text-align: center;">
                        {{ $rsbsa->memberInformation?->user?->surname ?? '' }}</div>
                    <div style="border-top: 1px solid #000; font-size: 8px; font-weight: bold; text-align: center;">
                        SURNAME</div>
                </div>
                <div style="flex: 1; padding: 2px 4px;">
                    <div style="min-height: 14px; font-weight: 500; text-align: center;">
                        {{ $rsbsa->memberInformation?->user?->first_name ?? '' }}</div>
                    <div style="border-top: 1px solid #000; font-size: 8px; font-weight: bold; text-align: center;">
                        FIRST NAME</div>
                </div>
            </div>

            <div style="display: flex; border-bottom: 1px solid #000;">
                <div style="flex: 1; padding: 2px 4px; border-right: 1px solid #000;">
                    <div style="min-height: 14px; font-weight: 500; text-align: center;">
                        {{ $rsbsa->memberInformation?->user?->middle_name ?? '' }}</div>
                    <div style="border-top: 1px solid #000; font-size: 8px; font-weight: bold; text-align: center;">
                        MIDDLE NAME</div>
                </div>
                <div style="width: 100px; padding: 2px 4px; border-right: 1px solid #000;">
                    <div style="min-height: 14px; font-weight: 500; text-align: center;">
                        {{ $rsbsa->extension_name ?? '' }}</div>
                    <div style="border-top: 1px solid #000; font-size: 8px; font-weight: bold; text-align: center;">
                        EXTENSION NAME</div>
                </div>
                <div
                    style="width: 120px; padding: 2px 4px; display: flex; align-items: center; justify-content: center;">
                    <span style="font-weight: bold; font-size: 8px;">SEX:</span>
                    <span class="chk {{ $rsbsa->memberInformation?->gender?->name === 'Male' ? 'checked' : '' }}"
                        style="margin-left: 8px;"></span> <span style="margin-left: 2px;">Male</span>
                    <span class="chk {{ $rsbsa->memberInformation?->gender?->name === 'Female' ? 'checked' : '' }}"
                        style="margin-left: 8px;"></span> <span style="margin-left: 2px;">Female</span>
                </div>
            </div>

            <!-- Address Section -->
            <div style="display: flex; border-bottom: 1px solid #000;">
                <div
                    style="width: 60px; font-weight: bold; padding: 2px 4px; font-size: 8px; display: flex; align-items: center;">
                    ADDRESS</div>
                <div style="flex: 1; display: flex;">
                    <div style="flex: 1; padding: 2px; border-left: 1px solid #000;">
                        <div
                            style="border: 1px solid #000; min-height: 14px; padding: 1px; font-size: 8px; text-align: center; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                            {{ $rsbsa->house_lot_bldg_purok ?? '' }}</div>
                        <div style="font-size: 9px; font-weight: bold; text-align: center;">HOUSE/LOT/BLDG. NO./PUROK
                        </div>
                    </div>
                    <div style="flex: 1; padding: 2px;">
                        <div
                            style="border: 1px solid #000; min-height: 14px; padding: 1px; font-size: 8px; text-align: center; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                            {{ $rsbsa->street_sitio_subdv ?? '' }}</div>
                        <div style="font-size: 9px; font-weight: bold; text-align: center;">STREET/SITIO/SUBDV.</div>
                    </div>
                    <div style="flex: 1; padding: 2px;">
                        <div
                            style="border: 1px solid #000; min-height: 14px; padding: 1px; font-size: 8px; text-align: center; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                            {{ $rsbsa->barangay ?? '' }}</div>
                        <div style="font-size: 9px; font-weight: bold; text-align: center;">BARANGAY</div>
                    </div>
                </div>
            </div>

            <div style="display: flex; border-bottom: 1px solid #000;">
                <div style="width: 60px; padding: 2px 4px; font-size: 8px; display: flex; align-items: center;"></div>
                <div style="flex: 1; display: flex;">
                    <div style="flex: 1; padding: 2px; border-left: 1px solid #000;">
                        <div
                            style="border: 1px solid #000; min-height: 14px; padding: 1px; font-size: 8px; text-align: center; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                            {{ $rsbsa->city_municipality ?? '' }}</div>
                        <div style="font-size: 9px; font-weight: bold; text-align: center;">MUNICIPALITY/CITY</div>
                    </div>
                    <div style="flex: 1; padding: 2px;">
                        <div
                            style="border: 1px solid #000; min-height: 14px; padding: 1px; font-size: 8px; text-align: center; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                            {{ $rsbsa->province ?? '' }}</div>
                        <div style="font-size: 9px; font-weight: bold; text-align: center;">PROVINCE</div>
                    </div>
                    <div style="flex: 1; padding: 2px;">
                        <div
                            style="border: 1px solid #000; min-height: 14px; padding: 1px; font-size: 8px; text-align: center; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                            {{ $rsbsa->region ?? '' }}</div>
                        <div style="font-size: 9px; font-weight: bold; text-align: center;">REGION</div>
                    </div>
                </div>
            </div>

            <!-- Two Column Section: Left (Contact/DOB/etc) | Right (Education/PWD/etc) -->
            <div style="display: flex; border-bottom: 1px solid #000;">
                <!-- LEFT COLUMN -->
                <div style="flex: 1; border-right: 1px solid #000;">
                    <!-- Mobile & Landline -->
                    <div style="display: flex; padding: 2px 4px; border-bottom: 1px solid #000;">
                        @php $mobile = $rsbsa->getFormattedContactNumber(); @endphp
                        <div style="flex: 1;">
                            <div style="font-weight: bold; font-size: 9px;">MOBILE NUMBER:</div>
                            <div style="display: flex;">
                                @for ($i = 0; $i < 11; $i++)
                                    <div class="digit-box">{{ $mobile[$i] ?? '' }}</div>
                                @endfor
                            </div>
                        </div>
                        @php $landline = $rsbsa->getFormattedLandlineNumber(); @endphp
                        <div style="flex: 1; margin-left: 8px;">
                            <div style="font-weight: bold; font-size: 9px;">LANDLINE NUMBER:</div>
                            <div style="display: flex;">
                                @for ($i = 0; $i < 10; $i++)
                                    <div class="digit-box">{{ $landline[$i] ?? '' }}</div>
                                @endfor
                            </div>
                        </div>
                    </div>

                    <!-- DOB & Place of Birth -->
                    <div style="display: flex; border-bottom: 1px solid #000;">
                        @php $dob = $rsbsa->getFormattedDateOfBirth(); @endphp
                        <div style="flex: 1; padding: 2px 4px; border-right: 1px solid #000;">
                            <div style="font-weight: bold; font-size: 9px;">DATE OF BIRTH:</div>
                            <div style="display: flex;">
                                @foreach ($dob as $d)
                                    <div class="digit-box">{{ $d }}</div>
                                @endforeach
                            </div>
                            <div style="font-size: 8px; display: flex; margin-top: 1px;">
                                <span style="width: 15px; text-align: center;">M</span>
                                <span style="width: 15px; text-align: center;">M</span>
                                <span style="width: 15px; text-align: center;">D</span>
                                <span style="width: 15px; text-align: center;">D</span>
                                <span style="width: 15px; text-align: center;">Y</span>
                                <span style="width: 15px; text-align: center;">Y</span>
                                <span style="width: 15px; text-align: center;">Y</span>
                                <span style="width: 15px; text-align: center;">Y</span>
                            </div>
                        </div>
                        <div style="flex: 1; padding: 2px 4px;">
                            <div style="font-weight: bold; font-size: 9px;">PLACE OF BIRTH:</div>
                            <div
                                style="border-bottom: 1px solid #000; min-height: 10px; font-size: 8px; text-align: center;">
                                {{ $rsbsa->place_of_birth_municipality ?? '' }}</div>
                            <div style="font-size: 8px; text-align: center;">MUNICIPALITY</div>
                            <div style="display: flex;">
                                <div style="flex: 1;">
                                    <div
                                        style="border-bottom: 1px solid #000; min-height: 10px; font-size: 8px; text-align: center;">
                                        {{ $rsbsa->place_of_birth_province ?? '' }}</div>
                                    <div style="font-size: 8px; text-align: center;">PROVINCE/STATE</div>
                                </div>
                                <div style="flex: 1; margin-left: 4px;">
                                    <div
                                        style="border-bottom: 1px solid #000; min-height: 10px; font-size: 8px; text-align: center;">
                                        {{ $rsbsa->place_of_birth_country ?? 'Philippines' }}</div>
                                    <div style="font-size: 8px; text-align: center;">COUNTRY</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Religion & Civil Status -->
                    <div style="padding: 2px 4px; border-bottom: 1px solid #000;">
                        <div style="display: flex; align-items: center;">
                            <span style="font-weight: bold; font-size: 8px;">RELIGION:</span>
                            <span class="chk" style="margin-left: 4px;"></span> <span
                                style="font-size: 8px; margin-left: 2px;">Christianity</span>
                            <span class="chk" style="margin-left: 4px;"></span> <span
                                style="font-size: 8px; margin-left: 2px;">Islam</span>
                            <span class="chk" style="margin-left: 4px;"></span> <span
                                style="font-size: 8px; margin-left: 2px;">Others, specify</span>
                            <span
                                style="border-bottom: 1px solid #000; width: 50px; margin-left: 2px; font-size: 8px;">{{ $rsbsa->memberInformation?->religion ?? '' }}</span>
                        </div>
                        <div style="display: flex; align-items: center; margin-top: 2px;">
                            <span style="font-weight: bold; font-size: 8px;">CIVIL STATUS:</span>
                            <span class="chk {{ $rsbsa->memberInformation?->isSingle() ? 'checked' : '' }}"
                                style="margin-left: 4px;"></span> <span
                                style="font-size: 8px; margin-left: 2px;">Single</span>
                            <span class="chk {{ $rsbsa->memberInformation?->isMarried() ? 'checked' : '' }}"
                                style="margin-left: 4px;"></span> <span
                                style="font-size: 8px; margin-left: 2px;">Married</span>
                            <span class="chk {{ $rsbsa->memberInformation?->isWidowed() ? 'checked' : '' }}"
                                style="margin-left: 4px;"></span> <span
                                style="font-size: 8px; margin-left: 2px;">Widowed</span>
                            <span class="chk {{ $rsbsa->memberInformation?->isSeparated() ? 'checked' : '' }}"
                                style="margin-left: 4px;"></span> <span
                                style="font-size: 8px; margin-left: 2px;">Separated</span>
                        </div>
                    </div>

                    <!-- Spouse -->
                    <div style="padding: 2px 4px; border-bottom: 1px solid #000;">
                        <div style="font-weight: bold; font-size: 9px;">NAME OF SPOUSE IF MARRIED:</div>
                        <div style="border-bottom: 1px solid #000; min-height: 12px; font-size: 8px;">
                            {{ $rsbsa->memberInformation->spouse ?? '' }}</div>
                    </div>

                    <!-- Mother's Maiden Name -->
                    <div style="padding: 2px 4px; border-bottom: 1px solid #000;">
                        <div style="font-weight: bold; font-size: 9px;">MOTHER'S MAIDEN NAME:</div>
                        <div style="border-bottom: 1px solid #000; min-height: 12px; font-size: 8px;">
                            {{ $rsbsa->memberInformation->mother_maiden_name ?? '' }}</div>
                    </div>

                    <!-- Household Head -->
                    <div style="padding: 2px 4px;">
                        <div style="display: flex; align-items: center;">
                            <span style="font-weight: bold; font-size: 8px;">HOUSEHOLD HEAD?</span>
                            <span class="chk {{ $rsbsa->household_head ? 'checked' : '' }}"
                                style="margin-left: 8px;"></span> <span
                                style="font-size: 8px; margin-left: 2px;">Yes</span>
                            <span class="chk {{ !$rsbsa->household_head ? 'checked' : '' }}"
                                style="margin-left: 8px;"></span> <span
                                style="font-size: 8px; margin-left: 2px;">No</span>
                        </div>
                        <div style="font-size: 8px; margin-top: 2px;">If no, name of household head: <span
                                style="border-bottom: 1px solid #000; display: inline-block; width: 120px;">{{ $rsbsa->name_of_household_head ?? '' }}</span>
                        </div>
                        <div style="font-size: 8px; margin-top: 1px; margin-left: 20px;">Relationship: <span
                                style="border-bottom: 1px solid #000; display: inline-block; width: 140px;">{{ $rsbsa->relationship_with_household_head ?? '' }}</span>
                        </div>
                        <div style="font-size: 8px; margin-top: 1px;">No. of living household members: <span
                                style="border-bottom: 1px solid #000; display: inline-block; width: 80px; text-align: center;">{{ $rsbsa->no_of_living_household_members ?? '' }}</span>
                        </div>
                        <div style="display: flex; font-size: 8px; margin-top: 1px;">
                            <span>No. of male: <span
                                    style="border-bottom: 1px solid #000; display: inline-block; width: 40px; text-align: center;">{{ $rsbsa->no_of_male ?? '' }}</span></span>
                            <span style="margin-left: 16px;">No. of female: <span
                                    style="border-bottom: 1px solid #000; display: inline-block; width: 40px; text-align: center;">{{ $rsbsa->no_of_female ?? '' }}</span></span>
                        </div>
                    </div>
                </div>

                <!-- RIGHT COLUMN -->
                <div style="flex: 1;">
                    <!-- Highest Formal Education -->
                    <div style="padding: 2px 4px; border-bottom: 1px solid #000;">
                        <div style="font-weight: bold; font-size: 9px;">HIGHEST FORMAL EDUCATION:</div>
                        <div style="display: flex; flex-wrap: wrap; gap: 2px; font-size: 8px;">
                            @foreach (\App\Models\RsbsaRecord::HIGHEST_FORMAL_EDUCATION as $key => $label)
                                <div style="width: 32%; display: flex; align-items: center;">
                                    <span class="chk {{ $rsbsa->isEducationLevel($key) ? 'checked' : '' }}"></span>
                                    <span style="margin-left: 2px;">{{ $label }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- PWD -->
                    <div style="display: flex; align-items: center; padding: 2px 4px; border-bottom: 1px solid #000;">
                        <span style="font-weight: bold; font-size: 8px;">PERSON WITH DISABILITY (PWD):</span>
                        <span class="chk {{ $rsbsa->is_pwd ? 'checked' : '' }}" style="margin-left: 8px;"></span>
                        <span style="font-size: 8px; margin-left: 2px;">Yes</span>
                        <span class="chk {{ !$rsbsa->is_pwd ? 'checked' : '' }}" style="margin-left: 8px;"></span>
                        <span style="font-size: 8px; margin-left: 2px;">No</span>
                    </div>

                    <!-- 4Ps -->
                    <div style="display: flex; align-items: center; padding: 2px 4px; border-bottom: 1px solid #000;">
                        <span style="font-weight: bold; font-size: 8px;">4P's Beneficiary?</span>
                        <span class="chk {{ $rsbsa->is_4ps_beneficiary ? 'checked' : '' }}"
                            style="margin-left: 8px;"></span> <span
                            style="font-size: 8px; margin-left: 2px;">Yes</span>
                        <span class="chk {{ !$rsbsa->is_4ps_beneficiary ? 'checked' : '' }}"
                            style="margin-left: 8px;"></span> <span
                            style="font-size: 8px; margin-left: 2px;">No</span>
                    </div>

                    <!-- Indigenous Group -->
                    <div style="padding: 2px 4px; border-bottom: 1px solid #000;">
                        <div style="display: flex; align-items: center;">
                            <span style="font-weight: bold; font-size: 8px;">Member of an <i>Indigenous
                                    Group</i>?</span>
                            <span class="chk {{ $rsbsa->is_indigenous_group_member ? 'checked' : '' }}"
                                style="margin-left: 8px;"></span> <span
                                style="font-size: 8px; margin-left: 2px;">Yes</span>
                            <span class="chk {{ !$rsbsa->is_indigenous_group_member ? 'checked' : '' }}"
                                style="margin-left: 8px;"></span> <span
                                style="font-size: 8px; margin-left: 2px;">No</span>
                        </div>
                        <div style="font-size: 8px; margin-top: 1px;">If yes, specify: <span
                                style="border-bottom: 1px solid #000; display: inline-block; width: 150px;">{{ $rsbsa->indigenous_group_name ?? '' }}</span>
                        </div>
                    </div>

                    <!-- Government ID -->
                    <div style="padding: 2px 4px; border-bottom: 1px solid #000;">
                        <div style="display: flex; align-items: center;">
                            <span style="font-weight: bold; font-size: 8px;">With <b>Government ID</b>?</span>
                            <span class="chk {{ $rsbsa->has_government_id ? 'checked' : '' }}"
                                style="margin-left: 8px;"></span> <span
                                style="font-size: 8px; margin-left: 2px;">Yes</span>
                            <span class="chk {{ !$rsbsa->has_government_id ? 'checked' : '' }}"
                                style="margin-left: 8px;"></span> <span
                                style="font-size: 8px; margin-left: 2px;">No</span>
                        </div>
                        <div style="font-size: 8px; margin-top: 1px;">If yes, specify <b>ID Type</b>: <span
                                style="border-bottom: 1px solid #000; display: inline-block; width: 120px;">{{ $rsbsa->id_type ?? '' }}</span>
                        </div>
                        <div style="font-size: 8px; margin-top: 1px;"><b>ID Number</b>: <span
                                style="border-bottom: 1px solid #000; display: inline-block; width: 150px;">{{ $rsbsa->id_number ?? '' }}</span>
                        </div>
                    </div>

                    <!-- Farmers Association -->
                    <div style="padding: 2px 4px; border-bottom: 1px solid #000;">
                        <div style="display: flex; align-items: center;">
                            <span style="font-weight: bold; font-size: 8px;">Member of any <b>Farmers
                                    Association/Cooperative</b>?</span>
                            <span class="chk {{ $rsbsa->is_farmers_association_member ? 'checked' : '' }}"
                                style="margin-left: 4px;"></span> <span
                                style="font-size: 8px; margin-left: 2px;">Yes</span>
                            <span class="chk {{ !$rsbsa->is_farmers_association_member ? 'checked' : '' }}"
                                style="margin-left: 4px;"></span> <span
                                style="font-size: 8px; margin-left: 2px;">No</span>
                        </div>
                        <div style="font-size: 8px; margin-top: 1px;">If yes, specify: <span
                                style="border-bottom: 1px solid #000; display: inline-block; width: 150px;">{{ $rsbsa->farmers_association_name ?? '' }}</span>
                        </div>
                    </div>

                    <!-- Emergency Contact -->
                    <div style="padding: 2px 4px;">
                        <div style="font-weight: bold; font-size: 9px;">PERSON TO NOTIFY IN CASE OF EMERGENCY:</div>
                        <div style="border-bottom: 1px solid #000; min-height: 12px; font-size: 8px;">
                            {{ $rsbsa->emergency_contact_name ?? '' }}</div>
                        @php $emergency = $rsbsa->getFormattedEmergencyContact(); @endphp
                        <div style="font-weight: bold; font-size: 8px; margin-top: 2px;">CONTACT NUMBER:</div>
                        <div style="display: flex;">
                            @foreach ($emergency as $d)
                                <div class="digit-box">{{ $d }}</div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <!-- PART II: FARM PROFILE -->
            <div class="section-header">PART II: FARM PROFILE</div>

            <!-- Main Livelihood -->
            <div
                style="display: flex; align-items: center; padding: 2px 4px; border-bottom: 1px solid #000; font-size: 8px;">
                <span style="font-weight: bold;">MAIN LIVELIHOOD</span>
                @foreach (\App\Models\RsbsaRecord::LIVELIHOOD_OPTION as $key => $label)
                    <span class="chk {{ $rsbsa->hasLivelihood($key) ? 'checked' : '' }}"
                        style="margin-left: 12px;"></span>
                    <span style="margin-left: 2px; font-weight: bold;">{{ strtoupper($label) }}</span>
                @endforeach
            </div>

            <!-- 4-Column Farm Profile -->
            <div style="display: flex; border-bottom: 1px solid #000; font-size: 8px;">
                <!-- Farmers -->
                <div style="flex: 1; padding: 2px 4px; border-right: 1px solid #000;">
                    <div style="font-weight: bold; font-style: italic; text-align: center;">For farmers:</div>
                    <div style="font-weight: bold;">Type of Farming Activity</div>
                    <div><span class="chk {{ $rsbsa->farming_rice ? 'checked' : '' }}"></span> Rice</div>
                    <div><span class="chk {{ $rsbsa->farming_corn ? 'checked' : '' }}"></span> Corn</div>
                    <div><span class="chk {{ $rsbsa->other_crops ? 'checked' : '' }}"></span> Other crops,</div>
                    <div style="margin-left: 12px;">please specify: <span
                            style="border-bottom: 1px solid #000; display: inline-block; width: 60px; font-size: 8px;">{{ $rsbsa->farming_other_crops ?? '' }}</span>
                    </div>
                    <div><span class="chk {{ $rsbsa->livestock ? 'checked' : '' }}"></span> Livestock,</div>
                    <div style="margin-left: 12px;">please specify: <span
                            style="border-bottom: 1px solid #000; display: inline-block; width: 60px; font-size: 8px;">{{ $rsbsa->farming_livestock ?? '' }}</span>
                    </div>
                    <div><span class="chk {{ $rsbsa->poultry ? 'checked' : '' }}"></span> Poultry,</div>
                    <div style="margin-left: 12px;">please specify: <span
                            style="border-bottom: 1px solid #000; display: inline-block; width: 60px; font-size: 8px;">{{ $rsbsa->farming_poultry ?? '' }}</span>
                    </div>
                </div>

                <!-- Farmworkers -->
                <div style="flex: 1; padding: 2px 4px; border-right: 1px solid #000;">
                    <div style="font-weight: bold; font-style: italic; text-align: center;">For farmworkers:</div>
                    <div style="font-weight: bold;">Kind of Work</div>
                    <div><span class="chk {{ $rsbsa->work_land_preparation ? 'checked' : '' }}"></span> Land
                        Preparation</div>
                    <div><span class="chk {{ $rsbsa->work_planting_transplanting ? 'checked' : '' }}"></span>
                        Planting/Transplanting</div>
                    <div><span class="chk {{ $rsbsa->work_cultivation ? 'checked' : '' }}"></span> Cultivation</div>
                    <div><span class="chk {{ $rsbsa->work_harvesting ? 'checked' : '' }}"></span> Harvesting</div>
                    <div><span class="chk {{ $rsbsa->work_others ? 'checked' : '' }}"></span> Others, please specify:
                    </div>
                    <div style="border-bottom: 1px solid #000; min-height: 10px; font-size: 8px;">
                        {{ $rsbsa->work_others_specify ?? '' }}</div>
                </div>

                <!-- Fisherfolk -->
                <div style="flex: 1; padding: 2px 4px; border-right: 1px solid #000;">
                    <div style="font-weight: bold; font-style: italic; text-align: center;">For fisherfolk:</div>
                    <div style="font-size: 8px; font-style: italic;">The Lending Conduit shall coordinate with the
                        Bureau of Fisheries and Aquatic Resources (BFAR) in the issuance of a certification that the
                        fisherfolk-borrower under PUNLA/PLEA is registered under the Municipal Registration (FishR).
                    </div>
                    <div style="font-weight: bold;">Type of Fishing Activity</div>
                    <div style="display: flex; flex-wrap: wrap;">
                        <div style="width: 50%;"><span
                                class="chk {{ $rsbsa->fishing_fish_capture ? 'checked' : '' }}"></span> Fish Capture
                        </div>
                        <div style="width: 50%;"><span
                                class="chk {{ $rsbsa->fishing_fish_processing ? 'checked' : '' }}"></span> Fish
                            Processing</div>
                        <div style="width: 50%;"><span
                                class="chk {{ $rsbsa->fishing_aquaculture ? 'checked' : '' }}"></span> Aquaculture
                        </div>
                        <div style="width: 50%;"><span
                                class="chk {{ $rsbsa->fishing_fish_vending ? 'checked' : '' }}"></span> Fish Vending
                        </div>
                        <div style="width: 50%;"><span
                                class="chk {{ $rsbsa->fishing_gleaning ? 'checked' : '' }}"></span> Gleaning</div>
                    </div>
                    <div><span class="chk {{ $rsbsa->fishing_others ? 'checked' : '' }}"></span> Others, please
                        specify:</div>
                    <div style="border-bottom: 1px solid #000; min-height: 10px; font-size: 8px;">
                        {{ $rsbsa->fishing_others_specify ?? '' }}</div>
                </div>

                <!-- Agri Youth -->
                <div style="flex: 1; padding: 2px 4px;">
                    <div style="font-weight: bold; font-style: italic; text-align: center;">For agri youth:</div>
                    <div style="font-size: 8px; font-style: italic;">For the purposes of trainings, financial
                        assistance, and other programs catered to the youth with involvement to any agriculture
                        activity.</div>
                    <div style="font-weight: bold;">Type of Involvement</div>
                    <div><span class="chk {{ $rsbsa->youth_farming_household ? 'checked' : '' }}"></span> part of a
                        farming household</div>
                    <div><span class="chk {{ $rsbsa->youth_agri_course ? 'checked' : '' }}"></span> attending/attended
                        formal agri-fishery related course</div>
                    <div><span class="chk {{ $rsbsa->youth_nonformal_agri_course ? 'checked' : '' }}"></span>
                        attending/attended non-formal agri-fishery related course</div>
                    <div><span class="chk {{ $rsbsa->youth_agri_program ? 'checked' : '' }}"></span> participated in
                        any agricultural activity/program</div>
                    <div><span class="chk {{ $rsbsa->youth_others ? 'checked' : '' }}"></span> others, specify:</div>
                    <div style="border-bottom: 1px solid #000; min-height: 10px; font-size: 8px;">
                        {{ $rsbsa->youth_others_specify ?? '' }}</div>
                </div>
            </div>

            <!-- Gross Annual Income -->
            <div style="display: flex; align-items: center; padding: 2px 4px; font-size: 8px;">
                <span style="font-weight: bold;">Gross Annual Income Last Year:</span>
                <span style="margin-left: 16px;">Farming:</span>
                <span
                    style="border-bottom: 1px solid #000; display: inline-block; width: 100px; margin-left: 4px; text-align: center;">₱{{ number_format($rsbsa->gross_annual_income_farming ?? 0, 2) }}</span>
                <span style="margin-left: 16px;">Non-farming:</span>
                <span
                    style="border-bottom: 1px solid #000; display: inline-block; width: 100px; margin-left: 4px; text-align: center;">₱{{ number_format($rsbsa->gross_annual_income_nonfarming ?? 0, 2) }}</span>
            </div>
        </div>

        <!-- Cut Line -->
        <div style="position: relative; height: 10px; margin: 4px 0;">
            <div style="position: absolute; left: 0; right: 0; top: 50%; border-top: 1px dashed #000;"></div>
            <div style="position: absolute; right: 0; top: 50%; transform: translateY(-50%) rotate(180deg);">✂</div>
        </div>

        <!-- CLIENT'S COPY -->
        <div
            style="border: 2px solid #000; border-top: 2px solid #000; border-bottom: 2px solid #000; border-left: 2px solid #000; border-right: 2px solid #000;">
            <div style="text-align: center; padding: 4px;">
                <div style="font-size: 11px; font-weight: bold;">Registry System for Basic Sectors in Agriculture
                    (RSBSA)</div>
                <div style="font-size: 11px; font-weight: bold;">ENROLLMENT CLIENT'S COPY</div>
            </div>

            <div style="display: flex; align-items: center; padding: 4px; font-size: 8px;">
                <span style="font-style: italic; font-weight: 600; width: 80px;">Reference Number:</span>
                <div style="display: flex; gap: 4px;">
                    <div>
                        <div style="display: flex;">
                            @foreach ($codes['region'] as $d)
                                <div class="digit-box">{{ $d }}</div>
                            @endforeach
                        </div>
                        <div style="text-align: center; font-size: 8px;">REGION</div>
                    </div>
                    <div>
                        <div style="display: flex;">
                            @foreach ($codes['province'] as $d)
                                <div class="digit-box">{{ $d }}</div>
                            @endforeach
                        </div>
                        <div style="text-align: center; font-size: 8px;">PROVINCE</div>
                    </div>
                    <div>
                        <div style="display: flex;">
                            @foreach ($codes['city_municipality'] as $d)
                                <div class="digit-box">{{ $d }}</div>
                            @endforeach
                        </div>
                        <div style="text-align: center; font-size: 8px;">CITY/MUNI</div>
                    </div>
                    <div>
                        <div style="display: flex;">
                            @foreach ($codes['barangay'] as $d)
                                <div class="digit-box">{{ $d }}</div>
                            @endforeach
                        </div>
                        <div style="text-align: center; font-size: 8px;">BARANGAY</div>
                    </div>
                    <div>
                        <div style="display: flex;">
                            @for ($i = 0; $i < 6; $i++)
                                <div class="digit-box"></div>
                            @endfor
                        </div>
                    </div>
                </div>
            </div>

            <div style="display: flex; padding: 4px;">
                <div style="flex: 1; padding: 2px;">
                    <div style="min-height: 12px; font-size: 9px; font-weight: 500; text-align: center;">
                        {{ $rsbsa->memberInformation?->user?->surname ?? '' }}</div>
                    <div style="border-top: 1px solid #000; font-size: 8px; font-weight: bold; text-align: center;">
                        SURNAME</div>
                </div>
                <div style="flex: 1; padding: 2px;">
                    <div style="min-height: 12px; font-size: 9px; font-weight: 500; text-align: center;">
                        {{ $rsbsa->memberInformation?->user?->first_name ?? '' }}</div>
                    <div style="border-top: 1px solid #000; font-size: 8px; font-weight: bold; text-align: center;">
                        FIRST NAME</div>
                </div>
            </div>

            <div style="display: flex; padding: 0 4px 4px 4px;">
                <div style="flex: 1; padding: 2px;">
                    <div style="min-height: 12px; font-size: 9px; font-weight: 500; text-align: center;">
                        {{ $rsbsa->memberInformation?->user?->middle_name ?? '' }}</div>
                    <div style="border-top: 1px solid #000; font-size: 8px; font-weight: bold; text-align: center;">
                        MIDDLE NAME</div>
                </div>
                <div style="flex: 1; padding: 2px;">
                    <div style="min-height: 12px; font-size: 9px; font-weight: 500; text-align: center;">
                        {{ $rsbsa->extension_name ?? '' }}</div>
                    <div style="border-top: 1px solid #000; font-size: 8px; font-weight: bold; text-align: center;">
                        EXTENSION NAME</div>
                </div>
            </div>


        </div>
    </div>
    <div style="text-align: center; font-weight: bold; font-size: 9px; padding: 3px; background-color: #fff;">
        THIS FORM IS NOT FOR SALE</div>
    <!-- ==================== PAGE 2 ==================== -->
    <div class="page-2 page-break no-break" style="font-size: 9px;">
        <div style="border: 1px solid #000;">
            <!-- Header -->
            <div style="display: flex; align-items: center; padding: 2px 4px; border-bottom: 1px solid #000;">
                <span style="font-weight: bold;">No. of Farm Parcels:</span>
                <span style="border-bottom: 1px solid #000; width: 30px; margin: 0 8px;"></span>
                <span style="font-weight: bold;">Name of Farmer/s in Rotation:</span>
                <span style="margin-left: 8px;">(P1)</span>
                <span style="border-bottom: 1px solid #000; width: 80px; margin: 0 4px;"></span>
                <span>(P2)</span>
                <span style="border-bottom: 1px solid #000; width: 80px; margin: 0 4px;"></span>
                <span>(P3)</span>
                <span style="border-bottom: 1px solid #000; width: 80px; margin: 0 4px;"></span>
            </div>

            <!-- Farm Parcels Table -->
            <table class="form-table" style="font-size: 8px;">
                <thead>
                    <tr style="font-weight: bold; text-align: center;">
                        <th style="width: 5%;">FARM PARCEL NO.</th>
                        <th style="width: 30%;">FARM LAND DESCRIPTION</th>
                        <th style="width: 12%;">CROP/COMMODITY<br><span
                                style="font-weight: normal; font-style: italic; font-size: 8px;">(Rice/Corn/HVC/Livestock/Poultry/Agri-fishery)</span><br><b>For
                                Livestock & Poultry</b><br><span
                                style="font-weight: normal; font-style: italic; font-size: 8px;">(specify type of
                                animal)</span></th>
                        <th style="width: 8%;">SIZE (ha)</th>
                        <th style="width: 8%;">NO. OF HEAD<br><span
                                style="font-weight: normal; font-style: italic; font-size: 8px;">(For Livestock and
                                Poultry)</span></th>
                        <th style="width: 8%;">FARM TYPE **</th>
                        <th style="width: 8%;">ORGANIC PRACTITIONER (Y/N)</th>
                        <th style="width: 10%;">REMARKS</th>
                    </tr>
                </thead>
                <tbody>
                    @for ($parcel = 1; $parcel <= 3; $parcel++)
                        <tr>
                            <td style="text-align: center; font-weight: bold;">{{ $parcel }}</td>
                            <td style="padding: 4px;">
                                <div><b>Farm Location:</b></div>
                                <div>
                                    <div style="border-bottom: 1px solid #000; min-height: 12px;"></div>
                                    <div style="font-size: 8px; text-align: center;">CITY/MUNICIPALITY</div>
                                </div>
                                <div>
                                    <div style="border-bottom: 1px solid #000; min-height: 12px;"></div>
                                    <div style="font-size: 8px; text-align: center;">BARANGAY</div>
                                </div>
                                <div style="margin-top: 2px;">
                                    <b>Total Farm Area (in hectares):</b> <span
                                        style="border-bottom: 1px solid #000; width: 30px; display: inline-block;"></span>
                                    ha
                                    <b style="margin-left: 4px;">Within Ancestral Domain:</b>
                                    <span class="chk" style="margin-left: 2px;"></span> Yes
                                    <span class="chk" style="margin-left: 2px;"></span> No
                                </div>
                                <div style="margin-top: 2px;">
                                    <b>Ownership Document No*:</b> <span
                                        style="border-bottom: 1px solid #000; width: 30px; display: inline-block;"></span>
                                    <b style="margin-left: 4px;">Agrarian Reform Beneficiary:</b>
                                    <span class="chk" style="margin-left: 2px;"></span> Yes
                                    <span class="chk" style="margin-left: 2px;"></span> No
                                </div>
                                <div style="margin-top: 2px;">
                                    <b>Ownership Type:</b><br>
                                    <span class="chk"></span> Registered Owner <span class="chk"
                                        style="margin-left: 4px;"></span> Others: <span
                                        style="border-bottom: 1px solid #000; width: 50px; display: inline-block;"></span><br>
                                    <span class="chk"></span> Tenant (Name of Land Owner: <span
                                        style="border-bottom: 1px solid #000; width: 70px; display: inline-block;"></span>)<br>
                                    <span class="chk"></span> Lessee (Name of Land Owner: <span
                                        style="border-bottom: 1px solid #000; width: 70px; display: inline-block;"></span>)
                                </div>
                            </td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                    @endfor
                </tbody>
            </table>

            <!-- Ownership Document & Farm Type Legend -->
            <div style="display: flex; padding: 4px; border-top: 1px solid #000;">
                <div style="flex: 2;">
                    <div style="font-weight: bold; font-size: 10px;">OWNERSHIP DOCUMENT *</div>
                    <div style="display: flex;">
                        <div style="flex: 1;">
                            <div>1. Certificate of Land Transfer</div>
                            <div>2. Emancipation Patent</div>
                            <div>3. Individual Certificate of Land Ownership Award (CLOA)</div>
                            <div>4. Collective CLOA</div>
                            <div>5. Co-ownership CLOA</div>
                        </div>
                        <div style="flex: 1;">
                            <div>6. Agricultural sales patent</div>
                            <div>7. Homestead patent</div>
                            <div>8. Free Patent</div>
                            <div>9. Certificate of Title or Regular Title</div>
                            <div>10. Certificate of Ancestral Domain Title</div>
                            <div>11. Certificate of Ancestral Land Title</div>
                            <div>12. Tax Declaration</div>
                            <div>13. Others (e.g. Barangay Certification)</div>
                        </div>
                    </div>
                </div>
                <div style="flex: 1; margin-left: 16px;">
                    <div style="font-weight: bold; font-size: 10px;">FARM TYPE **</div>
                    <div>1 - Irrigated</div>
                    <div>2 - Rainfed Upland</div>
                    <div>3 - Rainfed Lowland</div>
                    <div style="font-style: italic; font-size: 8px;">(NOTE: not applicable to agri-fishery)</div>
                </div>
            </div>

            <!-- Declaration -->
            <div style="padding: 2px 4px; border-top: 1px solid #000; font-size: 7px;">
                I hereby declare that all information indicated above are true and correct, and that they may be used by
                Department of Agriculture for the purposes of registration to the Registry System for Basic Sectors in
                Agriculture (RSBSA) and other legitimate interests of the Department pursuant to its mandates.
            </div>

            <!-- Signature Section -->
            <div style="display: flex; border-top: 1px solid #000; text-align: center;">
                <div style="flex: 1; border-right: 1px solid #000; padding: 2px;">
                    <div style="height: 30px; border-bottom: 1px solid #000;"></div>
                    <div class="section-header" style="font-size: 7px;">DATE</div>
                </div>
                <div style="flex: 1; border-right: 1px solid #000; padding: 2px;">
                    <div style="height: 30px; border-bottom: 1px solid #000;"></div>
                    <div class="section-header" style="font-size: 7px;">PRINTED NAME OF APPLICANT</div>
                </div>
                <div style="flex: 1; border-right: 1px solid #000; padding: 2px;">
                    <div style="height: 30px; border-bottom: 1px solid #000;"></div>
                    <div class="section-header" style="font-size: 7px;">SIGNATURE OF APPLICANT</div>
                </div>
                <div style="flex: 1; padding: 2px;">
                    <div style="height: 30px; border-bottom: 1px solid #000;"></div>
                    <div class="section-header" style="font-size: 7px;">THUMBMARK</div>
                </div>
            </div>

            <!-- Verified Section -->
            <div style="padding: 2px; border-top: 1px solid #000;">
                <div style="font-weight: bold; font-size: 8px;">VERIFIED TRUE AND CORRECT BY:</div>
                <div style="display: flex; text-align: center; margin-top: 4px;">
                    <div style="flex: 1; padding: 2px;">
                        <div style="border-bottom: 1px solid #000; height: 15px;"></div>
                        <div style="font-size: 7px;">SIGNATURE ABOVE PRINTED NAME / DATE</div>
                        <div style="font-weight: bold; font-size: 6px;">BARANGAY CHAIRMAN/CITY/MUN. VETERINARIAN
                            (LIVESTOCK)/MILL DISTRICT OFFICER (SUGARCANE)/IP LEADER/C/M/PARO (ARB)</div>
                    </div>
                    <div style="flex: 1; padding: 2px;">
                        <div style="border-bottom: 1px solid #000; height: 15px;"></div>
                        <div style="font-size: 7px;">SIGNATURE ABOVE PRINTED NAME / DATE</div>
                        <div style="font-weight: bold; font-size: 7px;">CITY/MUNICIPAL AGRICULTURE OFFICE</div>
                    </div>
                    <div style="flex: 1; padding: 2px;">
                        <div style="border-bottom: 1px solid #000; height: 15px;"></div>
                        <div style="font-size: 7px;">SIGNATURE ABOVE PRINTED NAME / DATE</div>
                        <div style="font-weight: bold; font-size: 7px;">CAFC/MAFC CHAIRMAN</div>
                    </div>
                </div>
            </div>

            <!-- Data Privacy Policy -->
            <div style="border-top: 1px solid #000;">
                <div class="section-header" style="text-align: center;">DATA PRIVACY POLICY</div>
                <div style="padding: 3px; font-size: 7px;">
                    <p>The collection of personal information is for documentation, planning, reporting and processing
                        purposes in availing agricultural related interventions. Processed data shall only be shared to
                        partner agencies for planning, reporting and other use in accordance to the mandate of the
                        agency. This is in compliance with the Data Sharing Policy of the department.</p>
                    <p style="margin-top: 4px;">You have the right to ask for a copy of your personal data that we hold
                        about you as well as to ask for it to be corrected if you think it is wrong. To do so, please
                        contact &lt;Contact Person and Contact Details&gt;.</p>
                </div>
            </div>

            <!-- Footer -->
            <div
                style="text-align: center; font-weight: bold; font-size: 9px; padding: 3px; border-top: 1px solid #000;">
                THIS FORM IS NOT FOR SALE</div>
        </div>
    </div>
</div>
