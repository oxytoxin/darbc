<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @mixin IdeHelperCluster
 */
class Cluster extends Model
{
    use HasFactory;

    public function leader()
    {
        return $this->belongsTo(User::class, 'leader_id');
    }

    public function members()
    {
        return $this->hasMany(MemberInformation::class);
    }

    public function active_members()
    {
        return $this->hasMany(MemberInformation::class)->active();
    }

    public function scopeOrderByName($query)
    {
        return $query->orderByRaw("name != '0',  CAST(name AS UNSIGNED)");
    }
}
