<?php

namespace App\Models;

use App\Casts\MoneyCast;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @mixin IdeHelperElderlyIncentiveType
 */
class ElderlyIncentiveType extends Model
{
    use HasFactory;

    protected $casts = [
        'amount' => MoneyCast::class,
    ];

    public function elderly_incentives()
    {
        return $this->hasMany(ElderlyIncentive::class);
    }
}
