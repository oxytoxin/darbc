<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @mixin IdeHelperOccupation
 */
class Occupation extends Model
{
    use HasFactory;

    const UNKNOWN = 5;

    public function members()
    {
        return $this->hasMany(MemberInformation::class);
    }
}
