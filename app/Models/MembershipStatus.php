<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @mixin IdeHelperMembershipStatus
 */
class MembershipStatus extends Model
{
    use HasFactory;

    const ORIGINAL = 1;
    const REPLACEMENT = 2;

    public function members()
    {
        return $this->hasMany(MemberInformation::class);
    }
}
