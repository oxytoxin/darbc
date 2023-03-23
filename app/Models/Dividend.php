<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Dividend extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $casts = [
        'restriction_entries' => 'array',
        'particulars' => 'array',
        'released_at' => 'immutable_datetime',
        'voided' => 'boolean',
    ];

    const PENDING = 1;
    const FOR_RELEASE = 2;
    const ON_HOLD = 3;
    const RELEASED = 4;

    const CLAIM_MEMBER = 1;
    const CLAIM_SPA = 2;
    const CLAIM_REPRESENTATIVE = 3;

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('proof_of_release')
            ->singleFile()
            ->useDisk('proof_of_release');
    }

    public function netAmount(): Attribute
    {
        return new Attribute(
            get: fn ($value) => $value / 100,
        );
    }

    public function grossAmount(): Attribute
    {
        return new Attribute(
            get: fn ($value) => $value / 100,
            set: fn ($value) => $value * 100,
        );
    }

    public function deductionsAmount(): Attribute
    {
        return new Attribute(
            get: fn ($value) => $value / 100,
            set: fn ($value) => $value * 100,
        );
    }

    public function release()
    {
        return $this->belongsTo(Release::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function cashier()
    {
        return $this->belongsTo(User::class, 'released_by');
    }
}
