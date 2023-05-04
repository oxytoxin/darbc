<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Filament\Models\Contracts\FilamentUser;
use Filament\Models\Contracts\HasName;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class User extends Authenticatable implements HasMedia, FilamentUser, HasName
{
    use HasApiTokens, HasFactory, Notifiable, InteractsWithMedia;

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    public function getFilamentName(): string
    {
        return "{$this->first_name} {$this->surname}";
    }

    public function canAccessFilament(): bool
    {
        return $this->username == 'admin';
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('signature')
            ->singleFile()
            ->useDisk('signatures');
    }

    // public function fullName(): Attribute
    // {
    //     return new Attribute(get: fn () => $this->surname . ', ' . $this->first_name);
    // }

    public function name(): Attribute
    {
        return new Attribute(get: fn () => $this->first_name . ' ' . $this->surname);
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    public function activeRole(): Attribute
    {
        return new Attribute(get: fn () => $this->roles()->first());
    }

    public function clusters_lead()
    {
        return $this->hasMany(Cluster::class, 'leader_id');
    }

    public function member_information()
    {
        return $this->hasOne(MemberInformation::class);
    }

    public function successors()
    {
        return $this->hasMany(MemberInformation::class, 'original_member_id');
    }

    public function scopeOnHold($query)
    {
        $query->has('active_restriction');
    }

    public function restrictions()
    {
        return $this->hasMany(Restriction::class);
    }

    public function dividends()
    {
        return $this->hasMany(Dividend::class);
    }

    public function active_restriction()
    {
        return $this->hasOne(Restriction::class)->ofMany('active')->whereActive(true);
    }

    public function cashier_released_dividends()
    {
        return $this->hasMany(Dividend::class, 'released_by');
    }

    public function daily_cash_starts()
    {
        return $this->hasMany(DailyCash::class, 'cashier_id')->where('type', DailyCash::TYPE_START);
    }

    public function daily_cash_ends()
    {
        return $this->hasMany(DailyCash::class, 'cashier_id')->where('type', DailyCash::TYPE_END);
    }

    public function daily_cashes()
    {
        return $this->hasMany(DailyCash::class, 'cashier_id');
    }
}
