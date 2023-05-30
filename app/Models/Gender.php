<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @mixin IdeHelperGender
 */
class Gender extends Model
{
    use HasFactory;

    const MALE = 1;
    const FEMALE = 2;
    const UNKNOWN = 3;

    public function members()
    {
        return $this->hasMany(MemberInformation::class);
    }
}
