<?php

namespace App\Http\Livewire\Shared;

use App\Models\ElderlyIncentive;
use App\Models\User;
use Livewire\Component;

class ElderlyIncentiveTemplate extends Component
{
    public User $user;
    public $incentive_id;

    public function mount()
    {
        if (request('incentive')) {
            $this->incentive_id = request('incentive');
        } else {
            $this->incentive_id = $this->user->elderly_incentives()->firstOrFail()->id;
        }
    }

    public function render()
    {
        return view('livewire.shared.elderly-incentive-template', [
            'incentive' => ElderlyIncentive::find($this->incentive_id)
        ]);
    }
}
