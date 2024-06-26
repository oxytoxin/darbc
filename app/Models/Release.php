<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @mixin IdeHelperRelease
 */
class Release extends Model
{
    use HasFactory;

    protected $casts = [
        'disbursed' => 'boolean',
        'voting_restriction' => 'boolean',
        'particulars' => 'array',
        'gift_certificate_amount' => 'decimal:2',
    ];

    public function totalAmount(): Attribute
    {
        return new Attribute(
            get: fn ($value) => $value / 100,
            set: fn ($value) => $value * 100,
        );
    }

    public function payslip()
    {
        return $this->hasOne(Payslip::class);
    }

    public function dividends()
    {
        return $this->hasMany(Dividend::class);
    }

    public function pending_dividends()
    {
        return $this->hasMany(Dividend::class)->where('status', Dividend::PENDING);
    }

    public function released_dividends()
    {
        return $this->hasMany(Dividend::class)->where('status', Dividend::RELEASED);
    }

    public function voided_dividends()
    {
        return $this->hasMany(Dividend::class)->where('status', Dividend::RELEASED)->whereVoided(true);
    }

    public function member_claimed_dividends()
    {
        return $this->hasMany(Dividend::class)->where('status', Dividend::RELEASED)->whereClaimType(Dividend::CLAIM_MEMBER);
    }

    public function spa_claimed_dividends()
    {
        return $this->hasMany(Dividend::class)->where('status', Dividend::RELEASED)->whereClaimType(Dividend::CLAIM_SPA);
    }

    public function representative_claimed_dividends()
    {
        return $this->hasMany(Dividend::class)->where('status', Dividend::RELEASED)->whereClaimType(Dividend::CLAIM_REPRESENTATIVE);
    }

    public function unclaimed_dividends()
    {
        return $this->hasMany(Dividend::class)->where('status', Dividend::FOR_RELEASE);
    }

    public function onhold_dividends()
    {
        return $this->hasMany(Dividend::class)->where('status', Dividend::ON_HOLD);
    }

    public function daily_cash_starts()
    {
        return $this->hasMany(DailyCash::class)->where('type', DailyCash::TYPE_START);
    }

    public function daily_cash_ends()
    {
        return $this->hasMany(DailyCash::class)->where('type', DailyCash::TYPE_END);
    }

    public function daily_cashes()
    {
        return $this->hasMany(DailyCash::class);
    }
}
