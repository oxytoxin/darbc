<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @mixin IdeHelperRole
 */
class Role extends Model
{
    use HasFactory;

    const RELEASE_ADMIN = 1;
    const CASHIER = 2;
    const OFFICE_STAFF = 3;
    const ADMIN = 4;
    const RSBSA_OFFICER = 5;

    public function users()
    {
        return $this->belongsToMany(User::class);
    }
}
