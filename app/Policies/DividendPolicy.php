<?php

namespace App\Policies;

use App\Models\Dividend;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class DividendPolicy
{
    use HandlesAuthorization;

    public function release(User $user, Dividend $dividend)
    {
        return $dividend->status === Dividend::FOR_RELEASE;
    }
}