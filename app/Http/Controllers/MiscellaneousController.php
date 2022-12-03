<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;

class MiscellaneousController extends Controller
{
    public function redirect()
    {
        switch (auth()->user()->active_role?->id) {
            case Role::ADMIN:
                return redirect()->route('administrator.dashboard');
                break;
            case Role::OFFICE_STAFF:
                return redirect()->route('office-staff.dashboard');
                break;
            case Role::CASHIER:
                return redirect()->route('cashier.dashboard');
                break;

            default:
                abort(404);
                break;
        }
    }
}
