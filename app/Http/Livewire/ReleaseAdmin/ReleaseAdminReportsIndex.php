<?php

namespace App\Http\Livewire\ReleaseAdmin;

use App\Models\Dividend;
use Livewire\Component;

class ReleaseAdminReportsIndex extends Component
{
    public function mount()
    {
    }

    public function render()
    {
        return view('livewire.release-admin.release-admin-reports-index');
    }
}
