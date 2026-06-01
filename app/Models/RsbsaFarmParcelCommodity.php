<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RsbsaFarmParcelCommodity extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'size' => 'decimal:4',
        'no_of_heads' => 'integer',
        'organic_practitioner' => 'boolean',
    ];

    const FARM_TYPES = [
        'Irrigated' => 'Irrigated',
        'Rainfed Upland' => 'Rainfed Upland',
        'Rainfed Lowland' => 'Rainfed Lowland',
        'Urban-Peri-Urban' => 'Urban-Peri-Urban',
        'Not Applicable' => 'Not Applicable',
    ];

    public function parcel(): BelongsTo
    {
        return $this->belongsTo(RsbsaFarmParcel::class, 'rsbsa_farm_parcel_id');
    }
}
