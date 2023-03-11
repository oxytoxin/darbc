<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FreeLot extends Model
{
    use HasFactory;

    protected $casts = [
        'sold_at' => 'immutable_date',
        'draw_date' => 'immutable_date',
        'status' => 'integer',
        'selling_history' => 'array',
        'relocation_history' => 'array',
        'swapping_history' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function cluster()
    {
        return $this->belongsTo(Cluster::class);
    }

    public function statusLabel(): Attribute
    {
        return new Attribute(
            get: fn () => match ($this->status) {
                1 => 'ACTIVE',
                2 => 'SOLD',
                3 => 'RELOCATED',
                4 => 'SWAPPED',
                default => 'UNKNOWN'
            }
        );
    }
}
