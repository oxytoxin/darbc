<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class MemberInformation extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    const STATUS_ACTIVE = 1;
    const STATUS_DECEASED = 2;
    const STATUS_INACTIVE = 3;

    protected $casts = [
        'date_of_birth' => 'immutable_date',
        'children' => 'array',
        'application_date' => 'immutable_date',
    ];

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('profile_photo')
            ->singleFile()
            ->useDisk('profile_photos');
        $this->addMediaCollection('consent_form')
            ->singleFile()
            ->useDisk('consent_forms');
        $this->addMediaCollection('identification_documents')
            ->useDisk('identification_documents');
    }

    public function scopeOriginal($query)
    {
        $query->whereMembershipStatusId(MembershipStatus::ORIGINAL);
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
}
