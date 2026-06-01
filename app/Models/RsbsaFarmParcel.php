<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RsbsaFarmParcel extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'total_parcel_area' => 'decimal:4',
        'within_ancestral_domain' => 'boolean',
        'agrarian_reform_beneficiary' => 'boolean',
        'has_land_ownership_proof' => 'boolean',
    ];

    const OWNERSHIP_TYPES = [
        'Registered Owner' => 'Registered Owner',
        'Tenant' => 'Tenant',
        'Lessee' => 'Lessee',
        'Others' => 'Others',
    ];

    public function rsbsaRecord(): BelongsTo
    {
        return $this->belongsTo(RsbsaRecord::class, 'rsbsa_record_id');
    }

    public function commodities(): HasMany
    {
        return $this->hasMany(RsbsaFarmParcelCommodity::class, 'rsbsa_farm_parcel_id');
    }
}
