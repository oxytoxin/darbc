<?php

namespace App\Models;

use App\Casts\MoneyCast;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ElderlyIncentive extends Model
{
    use HasFactory, SoftDeletes;

    protected $casts = [
        'amount' => MoneyCast::class,
    ];

    public function elderly_incentive_type()
    {
        return $this->belongsTo(ElderlyIncentiveType::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
