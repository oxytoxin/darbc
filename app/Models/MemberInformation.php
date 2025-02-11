<?php

namespace App\Models;

use DB;
use App\Models\RsbsaRecord;
use Spatie\MediaLibrary\HasMedia;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @mixin IdeHelperMemberInformation
 */
class MemberInformation extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    const STATUS_ACTIVE = 1;
    const STATUS_DECEASED = 2;
    const STATUS_INACTIVE = 3;

    const CS_SINGLE = 1;
    const CS_MARRIED = 2;
    const CS_WIDOW = 3;
    const CS_LEGALLY_SEPARATED = 4;
    const CS_UNKNOWN = 5;

    const FIELDS = [
        'cluster_id',
        'gender_id',
        'date_of_birth',
        'place_of_birth',
        'blood_type',
        'religion',
        'civil_status',
        'membership_status_id',
        'occupation_details',
        'address_line',
        'mother_maiden_name',
        'spouse',
        'sss_number',
        'philhealth_number',
        'tin_number',
        'contact_number',
    ];

    protected $casts = [
        'date_of_birth' => 'immutable_date',
        'children' => 'array',
        'spa' => 'array',
        'holographic' => 'boolean',
        'application_date' => 'immutable_date',
        'percentage' => 'decimal:2',
        'is_darbc_member' => 'boolean',
        'split_claim' => 'boolean',
        'succession_number' => 'integer',
    ];

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('profile_photo')
            ->singleFile()
            ->useDisk('profile_photos');
        $this->addMediaCollection('documents')
            ->useDisk('documents');
    }

    public function getProfilePhotoAttribute()
    {
        return $this->getFirstMedia('profile_photo')?->getUrl() ?? 'https://thumbs.dreamstime.com/b/default-avatar-profile-icon-vector-social-media-user-image-182145777.jpg';
    }

    public function missingDetails(): Attribute
    {
        return new Attribute(
            get: function () {
                return collect($this->toArray())
                    ->filter(function ($v, $k) {
                        return in_array($k, MemberInformation::FIELDS) && (
                            ($k == 'gender_id' && $v == Gender::UNKNOWN) ||
                            ($k == 'civil_status' && $v == MemberInformation::CS_UNKNOWN) ||
                            ($k == 'blood_type' && $v == 'Unknown') ||
                            is_null($v)
                        );
                    })->keys()->map(fn ($v) => str($v)->replace('_', ' ')->upper());
            }
        );
    }

    public function missingDetailsCount(): Attribute
    {
        return new Attribute(
            get: function () {
                return collect($this->toArray())
                    ->filter(function ($v, $k) {
                        return in_array($k, MemberInformation::FIELDS) && (
                            ($k == 'gender_id' && $v == Gender::UNKNOWN) ||
                            ($k == 'civil_status' && $v == MemberInformation::CS_UNKNOWN) ||
                            ($k == 'blood_type' && $v == 'Unknown') ||
                            is_null($v)
                        );
                    })->count();
            }
        );
    }

    public function scopeDarbcMember($query)
    {
        $query->whereIsDarbcMember(true);
    }

    public function scopeOriginal($query)
    {
        $query->whereIsDarbcMember(true)->whereMembershipStatusId(MembershipStatus::ORIGINAL);
    }

    public function scopeReplacement($query)
    {
        $query->whereMembershipStatusId(MembershipStatus::REPLACEMENT);
    }

    public function scopeActive($query)
    {
        $query->where('status', self::STATUS_ACTIVE);
    }

    public function scopeDeceased($query)
    {
        $query->where('status', self::STATUS_DECEASED);
    }

    public function scopeCelebrant($query)
    {
        $query->whereRaw('DAY(date_of_birth) = DAY(CURDATE())')->whereRaw('MONTH(date_of_birth) = MONTH(CURDATE())');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function cluster()
    {
        return $this->belongsTo(Cluster::class);
    }

    public function gender()
    {
        return $this->belongsTo(Gender::class);
    }

    public function membership_status()
    {
        return $this->belongsTo(MembershipStatus::class);
    }

    public function occupation()
    {
        return $this->belongsTo(Occupation::class);
    }

    public function original_member()
    {
        return $this->belongsTo(User::class, 'original_member_id');
    }

    public function region()
    {
        return $this->belongsTo(Region::class, 'region_code', 'code');
    }

    public function province()
    {
        return $this->belongsTo(Province::class, 'province_code', 'code');
    }

    public function city()
    {
        return $this->belongsTo(City::class, 'city_code', 'code');
    }

    public function barangay()
    {
        return $this->belongsTo(Barangay::class, 'barangay_code', 'code');
    }

    public function rsbsa(){
        return $this->hasOne(RsbsaRecord::class);
    }



    public function hasRsbsaRecord()
{
    return $this->rsbsa()->exists();
}


public static function countWithRsbsa()
{
    return self::whereHas('rsbsa')->count();
}

public static function countWithoutRsbsa()
{
    return self::whereDoesntHave('rsbsa')->count();
}

}


