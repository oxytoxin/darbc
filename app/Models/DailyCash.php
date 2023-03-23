<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DailyCash extends Model
{
    use HasFactory;

    const TYPE_START = 1;
    const TYPE_END = 2;
    const STATUS_DRAFT = 1;
    const STATUS_FINAL = 2;

    const DEFAULT_DENOMINATIONS = [
        [
            'denomination' => '1000',
            'count' => 0,
        ],
        [
            'denomination' => '500',
            'count' => 0,
        ],
        [
            'denomination' => '200',
            'count' => 0,
        ],
        [
            'denomination' => '100',
            'count' => 0,
        ],
        [
            'denomination' => '50',
            'count' => 0,
        ],
        [
            'denomination' => '20',
            'count' => 0,
        ],
        [
            'denomination' => '10',
            'count' => 0,
        ],
        [
            'denomination' => '5',
            'count' => 0,
        ],
        [
            'denomination' => '1',
            'count' => 0,
        ],
    ];

    protected $casts = [
        'denominations' => 'array',
    ];

    public function amount(): Attribute
    {
        return new Attribute(
            get: fn ($value) => $value / 100,
            set: fn ($value) => $value * 100
        );
    }

    public function denominations(): Attribute
    {
        return new Attribute(
            get: function ($value) {
                $denominations = collect(json_decode($value, true));
                return $denominations->map(fn ($d) => ['denomination' => $d['denomination'], 'count' => $d['count']]);
            }
        );
    }

    public function cashier()
    {
        return $this->belongsTo(User::class, 'cashier_id');
    }

    public function scopeToday($query)
    {
        return $query->whereDate('created_at', today());
    }

    public function scopeForRelease($query, $release_id)
    {
        return $query->whereReleaseId($release_id);
    }
}
