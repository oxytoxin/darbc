<?php

// @formatter:off
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models {
    /**
     * App\Models\Barangay
     *
     * @property int $id
     * @property string|null $code
     * @property string|null $description
     * @property string|null $region_code
     * @property string|null $province_code
     * @property string|null $city_code
     * @method static \Illuminate\Database\Eloquent\Builder|Barangay newModelQuery()
     * @method static \Illuminate\Database\Eloquent\Builder|Barangay newQuery()
     * @method static \Illuminate\Database\Eloquent\Builder|Barangay query()
     * @method static \Illuminate\Database\Eloquent\Builder|Barangay whereCityCode($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Barangay whereCode($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Barangay whereDescription($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Barangay whereId($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Barangay whereProvinceCode($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Barangay whereRegionCode($value)
     */
    class Barangay extends \Eloquent
    {
    }
}

namespace App\Models {
    /**
     * App\Models\City
     *
     * @property int $id
     * @property string|null $psgc_code
     * @property string|null $description
     * @property string|null $region_code
     * @property string|null $province_code
     * @property string|null $code
     * @method static \Illuminate\Database\Eloquent\Builder|City newModelQuery()
     * @method static \Illuminate\Database\Eloquent\Builder|City newQuery()
     * @method static \Illuminate\Database\Eloquent\Builder|City query()
     * @method static \Illuminate\Database\Eloquent\Builder|City whereCode($value)
     * @method static \Illuminate\Database\Eloquent\Builder|City whereDescription($value)
     * @method static \Illuminate\Database\Eloquent\Builder|City whereId($value)
     * @method static \Illuminate\Database\Eloquent\Builder|City whereProvinceCode($value)
     * @method static \Illuminate\Database\Eloquent\Builder|City wherePsgcCode($value)
     * @method static \Illuminate\Database\Eloquent\Builder|City whereRegionCode($value)
     */
    class City extends \Eloquent
    {
    }
}

namespace App\Models {
    /**
     * App\Models\Cluster
     *
     * @property int $id
     * @property string $name
     * @property int $leader_id
     * @property \Illuminate\Support\Carbon|null $created_at
     * @property \Illuminate\Support\Carbon|null $updated_at
     * @property-read \App\Models\User $leader
     * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\MemberInformation[] $members
     * @property-read int|null $members_count
     * @method static \Illuminate\Database\Eloquent\Builder|Cluster newModelQuery()
     * @method static \Illuminate\Database\Eloquent\Builder|Cluster newQuery()
     * @method static \Illuminate\Database\Eloquent\Builder|Cluster query()
     * @method static \Illuminate\Database\Eloquent\Builder|Cluster whereCreatedAt($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Cluster whereId($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Cluster whereLeaderId($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Cluster whereName($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Cluster whereUpdatedAt($value)
     */
    class Cluster extends \Eloquent
    {
    }
}

namespace App\Models {
    /**
     * App\Models\Dividend
     *
     * @property int $id
     * @property int $release_id
     * @property int $user_id
     * @property int $gross_amount
     * @property int $deductions_amount
     * @property int $status
     * @property array $restriction_entries
     * @property int|null $released_by
     * @property \Carbon\CarbonImmutable|null $released_at
     * @property \Illuminate\Support\Carbon|null $created_at
     * @property \Illuminate\Support\Carbon|null $updated_at
     * @property-read \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection|\Spatie\MediaLibrary\MediaCollections\Models\Media[] $media
     * @property-read int|null $media_count
     * @property-read \App\Models\Release $release
     * @property-read \App\Models\User $user
     * @method static \Illuminate\Database\Eloquent\Builder|Dividend newModelQuery()
     * @method static \Illuminate\Database\Eloquent\Builder|Dividend newQuery()
     * @method static \Illuminate\Database\Eloquent\Builder|Dividend query()
     * @method static \Illuminate\Database\Eloquent\Builder|Dividend whereCreatedAt($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Dividend whereDeductionsAmount($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Dividend whereGrossAmount($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Dividend whereId($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Dividend whereReleaseId($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Dividend whereReleasedAt($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Dividend whereReleasedBy($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Dividend whereRestrictionEntries($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Dividend whereStatus($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Dividend whereUpdatedAt($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Dividend whereUserId($value)
     */
    class Dividend extends \Eloquent implements \Spatie\MediaLibrary\HasMedia
    {
    }
}

namespace App\Models {
    /**
     * App\Models\Gender
     *
     * @property int $id
     * @property string $name
     * @property \Illuminate\Support\Carbon|null $created_at
     * @property \Illuminate\Support\Carbon|null $updated_at
     * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\MemberInformation[] $members
     * @property-read int|null $members_count
     * @method static \Illuminate\Database\Eloquent\Builder|Gender newModelQuery()
     * @method static \Illuminate\Database\Eloquent\Builder|Gender newQuery()
     * @method static \Illuminate\Database\Eloquent\Builder|Gender query()
     * @method static \Illuminate\Database\Eloquent\Builder|Gender whereCreatedAt($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Gender whereId($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Gender whereName($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Gender whereUpdatedAt($value)
     */
    class Gender extends \Eloquent
    {
    }
}

namespace App\Models {
    /**
     * App\Models\LandRecording
     *
     * @property int $id
     * @property int $user_id
     * @property int|null $province_id
     * @property int|null $region_id
     * @property int|null $city_id
     * @property int|null $barangay_id
     * @property string $area_size
     * @property \Illuminate\Support\Carbon|null $created_at
     * @property \Illuminate\Support\Carbon|null $updated_at
     * @method static \Illuminate\Database\Eloquent\Builder|LandRecording newModelQuery()
     * @method static \Illuminate\Database\Eloquent\Builder|LandRecording newQuery()
     * @method static \Illuminate\Database\Eloquent\Builder|LandRecording query()
     * @method static \Illuminate\Database\Eloquent\Builder|LandRecording whereAreaSize($value)
     * @method static \Illuminate\Database\Eloquent\Builder|LandRecording whereBarangayId($value)
     * @method static \Illuminate\Database\Eloquent\Builder|LandRecording whereCityId($value)
     * @method static \Illuminate\Database\Eloquent\Builder|LandRecording whereCreatedAt($value)
     * @method static \Illuminate\Database\Eloquent\Builder|LandRecording whereId($value)
     * @method static \Illuminate\Database\Eloquent\Builder|LandRecording whereProvinceId($value)
     * @method static \Illuminate\Database\Eloquent\Builder|LandRecording whereRegionId($value)
     * @method static \Illuminate\Database\Eloquent\Builder|LandRecording whereUpdatedAt($value)
     * @method static \Illuminate\Database\Eloquent\Builder|LandRecording whereUserId($value)
     */
    class LandRecording extends \Eloquent
    {
    }
}

namespace App\Models {
    /**
     * App\Models\MemberInformation
     *
     * @property int $id
     * @property int $status
     * @property string $darbc_id
     * @property int $user_id
     * @property int $cluster_id
     * @property int $succession_number
     * @property int|null $original_member_id
     * @property \Carbon\CarbonImmutable $date_of_birth
     * @property string $place_of_birth
     * @property int $gender_id
     * @property string $blood_type
     * @property string $religion
     * @property int $membership_status_id
     * @property int $occupation_id
     * @property string|null $occupation_details
     * @property string|null $province_code
     * @property string|null $region_code
     * @property string|null $city_code
     * @property string|null $barangay_code
     * @property string|null $address_line
     * @property int $civil_status
     * @property mixed $children
     * @property string|null $sss_number
     * @property string|null $philhealth_number
     * @property string|null $tin_number
     * @property string|null $contact_number
     * @property \Carbon\CarbonImmutable $application_date
     * @property \Illuminate\Support\Carbon|null $created_at
     * @property \Illuminate\Support\Carbon|null $updated_at
     * @property-read \App\Models\Barangay|null $barangay
     * @property-read \App\Models\City|null $city
     * @property-read \App\Models\Cluster $cluster
     * @property-read \App\Models\Gender $gender
     * @property-read \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection|\Spatie\MediaLibrary\MediaCollections\Models\Media[] $media
     * @property-read int|null $media_count
     * @property-read \App\Models\MembershipStatus $membership_status
     * @property-read \App\Models\Occupation $occupation
     * @property-read \App\Models\User|null $original_member
     * @property-read \App\Models\Province|null $province
     * @property-read \App\Models\Region|null $region
     * @property-read \App\Models\User $user
     * @method static \Illuminate\Database\Eloquent\Builder|MemberInformation active()
     * @method static \Illuminate\Database\Eloquent\Builder|MemberInformation deceased()
     * @method static \Database\Factories\MemberInformationFactory factory(...$parameters)
     * @method static \Illuminate\Database\Eloquent\Builder|MemberInformation newModelQuery()
     * @method static \Illuminate\Database\Eloquent\Builder|MemberInformation newQuery()
     * @method static \Illuminate\Database\Eloquent\Builder|MemberInformation original()
     * @method static \Illuminate\Database\Eloquent\Builder|MemberInformation query()
     * @method static \Illuminate\Database\Eloquent\Builder|MemberInformation replacement()
     * @method static \Illuminate\Database\Eloquent\Builder|MemberInformation whereAddressLine($value)
     * @method static \Illuminate\Database\Eloquent\Builder|MemberInformation whereApplicationDate($value)
     * @method static \Illuminate\Database\Eloquent\Builder|MemberInformation whereBarangayCode($value)
     * @method static \Illuminate\Database\Eloquent\Builder|MemberInformation whereBloodType($value)
     * @method static \Illuminate\Database\Eloquent\Builder|MemberInformation whereChildren($value)
     * @method static \Illuminate\Database\Eloquent\Builder|MemberInformation whereCityCode($value)
     * @method static \Illuminate\Database\Eloquent\Builder|MemberInformation whereCivilStatus($value)
     * @method static \Illuminate\Database\Eloquent\Builder|MemberInformation whereClusterId($value)
     * @method static \Illuminate\Database\Eloquent\Builder|MemberInformation whereContactNumber($value)
     * @method static \Illuminate\Database\Eloquent\Builder|MemberInformation whereCreatedAt($value)
     * @method static \Illuminate\Database\Eloquent\Builder|MemberInformation whereDarbcId($value)
     * @method static \Illuminate\Database\Eloquent\Builder|MemberInformation whereDateOfBirth($value)
     * @method static \Illuminate\Database\Eloquent\Builder|MemberInformation whereGenderId($value)
     * @method static \Illuminate\Database\Eloquent\Builder|MemberInformation whereId($value)
     * @method static \Illuminate\Database\Eloquent\Builder|MemberInformation whereMembershipStatusId($value)
     * @method static \Illuminate\Database\Eloquent\Builder|MemberInformation whereOccupationDetails($value)
     * @method static \Illuminate\Database\Eloquent\Builder|MemberInformation whereOccupationId($value)
     * @method static \Illuminate\Database\Eloquent\Builder|MemberInformation whereOriginalMemberId($value)
     * @method static \Illuminate\Database\Eloquent\Builder|MemberInformation wherePhilhealthNumber($value)
     * @method static \Illuminate\Database\Eloquent\Builder|MemberInformation wherePlaceOfBirth($value)
     * @method static \Illuminate\Database\Eloquent\Builder|MemberInformation whereProvinceCode($value)
     * @method static \Illuminate\Database\Eloquent\Builder|MemberInformation whereRegionCode($value)
     * @method static \Illuminate\Database\Eloquent\Builder|MemberInformation whereReligion($value)
     * @method static \Illuminate\Database\Eloquent\Builder|MemberInformation whereSssNumber($value)
     * @method static \Illuminate\Database\Eloquent\Builder|MemberInformation whereStatus($value)
     * @method static \Illuminate\Database\Eloquent\Builder|MemberInformation whereSuccessorNumber($value)
     * @method static \Illuminate\Database\Eloquent\Builder|MemberInformation whereTinNumber($value)
     * @method static \Illuminate\Database\Eloquent\Builder|MemberInformation whereUpdatedAt($value)
     * @method static \Illuminate\Database\Eloquent\Builder|MemberInformation whereUserId($value)
     */
    class MemberInformation extends \Eloquent implements \Spatie\MediaLibrary\HasMedia
    {
    }
}

namespace App\Models {
    /**
     * App\Models\MembershipStatus
     *
     * @property int $id
     * @property string $name
     * @property \Illuminate\Support\Carbon|null $created_at
     * @property \Illuminate\Support\Carbon|null $updated_at
     * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\MemberInformation[] $members
     * @property-read int|null $members_count
     * @method static \Illuminate\Database\Eloquent\Builder|MembershipStatus newModelQuery()
     * @method static \Illuminate\Database\Eloquent\Builder|MembershipStatus newQuery()
     * @method static \Illuminate\Database\Eloquent\Builder|MembershipStatus query()
     * @method static \Illuminate\Database\Eloquent\Builder|MembershipStatus whereCreatedAt($value)
     * @method static \Illuminate\Database\Eloquent\Builder|MembershipStatus whereId($value)
     * @method static \Illuminate\Database\Eloquent\Builder|MembershipStatus whereName($value)
     * @method static \Illuminate\Database\Eloquent\Builder|MembershipStatus whereUpdatedAt($value)
     */
    class MembershipStatus extends \Eloquent
    {
    }
}

namespace App\Models {
    /**
     * App\Models\Occupation
     *
     * @property int $id
     * @property string $name
     * @property \Illuminate\Support\Carbon|null $created_at
     * @property \Illuminate\Support\Carbon|null $updated_at
     * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\MemberInformation[] $members
     * @property-read int|null $members_count
     * @method static \Illuminate\Database\Eloquent\Builder|Occupation newModelQuery()
     * @method static \Illuminate\Database\Eloquent\Builder|Occupation newQuery()
     * @method static \Illuminate\Database\Eloquent\Builder|Occupation query()
     * @method static \Illuminate\Database\Eloquent\Builder|Occupation whereCreatedAt($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Occupation whereId($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Occupation whereName($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Occupation whereUpdatedAt($value)
     */
    class Occupation extends \Eloquent
    {
    }
}

namespace App\Models {
    /**
     * App\Models\Province
     *
     * @property int $id
     * @property string|null $psgc_code
     * @property string|null $description
     * @property string|null $region_code
     * @property string|null $code
     * @method static \Illuminate\Database\Eloquent\Builder|Province newModelQuery()
     * @method static \Illuminate\Database\Eloquent\Builder|Province newQuery()
     * @method static \Illuminate\Database\Eloquent\Builder|Province query()
     * @method static \Illuminate\Database\Eloquent\Builder|Province whereCode($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Province whereDescription($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Province whereId($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Province wherePsgcCode($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Province whereRegionCode($value)
     */
    class Province extends \Eloquent
    {
    }
}

namespace App\Models {
    /**
     * App\Models\Region
     *
     * @property int $id
     * @property string|null $psgc_code
     * @property string|null $description
     * @property string|null $code
     * @method static \Illuminate\Database\Eloquent\Builder|Region newModelQuery()
     * @method static \Illuminate\Database\Eloquent\Builder|Region newQuery()
     * @method static \Illuminate\Database\Eloquent\Builder|Region query()
     * @method static \Illuminate\Database\Eloquent\Builder|Region whereCode($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Region whereDescription($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Region whereId($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Region wherePsgcCode($value)
     */
    class Region extends \Eloquent
    {
    }
}

namespace App\Models {
    /**
     * App\Models\Release
     *
     * @property int $id
     * @property string $name
     * @property int $total_amount
     * @property int $disbursed
     * @property \Illuminate\Support\Carbon|null $created_at
     * @property \Illuminate\Support\Carbon|null $updated_at
     * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Dividend[] $dividends
     * @property-read int|null $dividends_count
     * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Dividend[] $onhold_dividends
     * @property-read int|null $onhold_dividends_count
     * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Dividend[] $pending_dividends
     * @property-read int|null $pending_dividends_count
     * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Dividend[] $released_dividends
     * @property-read int|null $released_dividends_count
     * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Dividend[] $unclaimed_dividends
     * @property-read int|null $unclaimed_dividends_count
     * @method static \Database\Factories\ReleaseFactory factory(...$parameters)
     * @method static \Illuminate\Database\Eloquent\Builder|Release newModelQuery()
     * @method static \Illuminate\Database\Eloquent\Builder|Release newQuery()
     * @method static \Illuminate\Database\Eloquent\Builder|Release query()
     * @method static \Illuminate\Database\Eloquent\Builder|Release whereCreatedAt($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Release whereDisbursed($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Release whereId($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Release whereName($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Release whereTotalAmount($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Release whereUpdatedAt($value)
     */
    class Release extends \Eloquent
    {
    }
}

namespace App\Models {
    /**
     * App\Models\Restriction
     *
     * @property int $id
     * @property int $user_id
     * @property int $active
     * @property array $entries
     * @property \Illuminate\Support\Carbon|null $created_at
     * @property \Illuminate\Support\Carbon|null $updated_at
     * @method static \Illuminate\Database\Eloquent\Builder|Restriction newModelQuery()
     * @method static \Illuminate\Database\Eloquent\Builder|Restriction newQuery()
     * @method static \Illuminate\Database\Eloquent\Builder|Restriction query()
     * @method static \Illuminate\Database\Eloquent\Builder|Restriction whereActive($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Restriction whereCreatedAt($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Restriction whereEntries($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Restriction whereId($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Restriction whereUpdatedAt($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Restriction whereUserId($value)
     */
    class Restriction extends \Eloquent
    {
    }
}

namespace App\Models {
    /**
     * App\Models\Role
     *
     * @property int $id
     * @property string $name
     * @property \Illuminate\Support\Carbon|null $created_at
     * @property \Illuminate\Support\Carbon|null $updated_at
     * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\User[] $users
     * @property-read int|null $users_count
     * @method static \Illuminate\Database\Eloquent\Builder|Role newModelQuery()
     * @method static \Illuminate\Database\Eloquent\Builder|Role newQuery()
     * @method static \Illuminate\Database\Eloquent\Builder|Role query()
     * @method static \Illuminate\Database\Eloquent\Builder|Role whereCreatedAt($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Role whereId($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Role whereName($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Role whereUpdatedAt($value)
     */
    class Role extends \Eloquent
    {
    }
}

namespace App\Models {
    /**
     * App\Models\User
     *
     * @property int $id
     * @property string $first_name
     * @property string|null $middle_name
     * @property string $surname
     * @property string|null $suffix
     * @property string $username
     * @property string $password
     * @property string|null $remember_token
     * @property \Illuminate\Support\Carbon|null $created_at
     * @property \Illuminate\Support\Carbon|null $updated_at
     * @property-read \App\Models\Restriction|null $active_restriction
     * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Cluster[] $clusters_lead
     * @property-read int|null $clusters_lead_count
     * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Dividend[] $dividends
     * @property-read int|null $dividends_count
     * @property-read \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection|\Spatie\MediaLibrary\MediaCollections\Models\Media[] $media
     * @property-read int|null $media_count
     * @property-read \App\Models\MemberInformation|null $member_information
     * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
     * @property-read int|null $notifications_count
     * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Restriction[] $restrictions
     * @property-read int|null $restrictions_count
     * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Role[] $roles
     * @property-read int|null $roles_count
     * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\MemberInformation[] $successors
     * @property-read int|null $successors_count
     * @property-read \Illuminate\Database\Eloquent\Collection|\Laravel\Sanctum\PersonalAccessToken[] $tokens
     * @property-read int|null $tokens_count
     * @method static \Database\Factories\UserFactory factory(...$parameters)
     * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
     * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
     * @method static \Illuminate\Database\Eloquent\Builder|User onHold()
     * @method static \Illuminate\Database\Eloquent\Builder|User query()
     * @method static \Illuminate\Database\Eloquent\Builder|User whereCreatedAt($value)
     * @method static \Illuminate\Database\Eloquent\Builder|User whereFirstName($value)
     * @method static \Illuminate\Database\Eloquent\Builder|User whereId($value)
     * @method static \Illuminate\Database\Eloquent\Builder|User whereMiddleName($value)
     * @method static \Illuminate\Database\Eloquent\Builder|User wherePassword($value)
     * @method static \Illuminate\Database\Eloquent\Builder|User whereRememberToken($value)
     * @method static \Illuminate\Database\Eloquent\Builder|User whereSuffix($value)
     * @method static \Illuminate\Database\Eloquent\Builder|User whereSurname($value)
     * @method static \Illuminate\Database\Eloquent\Builder|User whereUpdatedAt($value)
     * @method static \Illuminate\Database\Eloquent\Builder|User whereUsername($value)
     */
    class User extends \Eloquent implements \Spatie\MediaLibrary\HasMedia
    {
    }
}
