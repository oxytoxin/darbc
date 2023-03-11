<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FreeLot extends Model
{
    use HasFactory;

    protected $casts = [
        'sold_at' => 'immutable_date',
        'draw_date' => 'immutable_date',
        'status' => 'integer',
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
}
