<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;

class MiscellaneousController extends Controller
{
    public function redirect()
    {
        switch (session('active_role') ?? auth()->user()->active_role?->id) {
            case Role::ADMIN:
                return redirect()->route('admin.manage-users');
                break;
            case Role::RELEASE_ADMIN:
                return redirect()->route('release-admin.dashboard');
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
