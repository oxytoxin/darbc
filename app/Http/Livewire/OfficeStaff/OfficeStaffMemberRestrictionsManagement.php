<?php

namespace App\Http\Livewire\OfficeStaff;

use App\Http\Livewire\Shared\MemberRestrictionsManagement;
use App\Models\MemberInformation;
use Livewire\Component;
use App\Models\Restriction;
use Filament\Tables\Actions\Action;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TagsColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TagsInput;
use Filament\Notifications\Notification;
use Filament\Tables\Actions\CreateAction;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;

class OfficeStaffMemberRestrictionsManagement extends MemberRestrictionsManagement
{

    public function render()
    {
        return view('livewire.office-staff.office-staff-member-restrictions-management');
    }
}
