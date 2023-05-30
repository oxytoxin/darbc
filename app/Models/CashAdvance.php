<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @mixin IdeHelperCashAdvance
 */
class CashAdvance extends Model
{
    use HasFactory;

    protected $casts = [
        'date_received' => 'immutable_date',
        'date_approved' => 'immutable_date',
        'other_details' => 'array',
    ];

    public function requestedAmount(): Attribute
    {
        return new Attribute(
            get: fn ($value) => $value / 100,
            set: fn ($value) => $value * 100
        );
    }

    public function approvedAmount(): Attribute
    {
        return new Attribute(
            get: fn ($value) => $value / 100,
            set: fn ($value) => $value * 100
        );
    }

    public function accountAmount(): Attribute
    {
        return new Attribute(
            get: fn ($value) => $value / 100,
            set: fn ($value) => $value * 100
        );
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
