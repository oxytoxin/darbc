<?php

namespace App\Http\Livewire\ReleaseAdmin;

use App\Http\Livewire\ReleaseDividends;
use App\Models\User;
use Filament\Forms\Components\Select;
use Filament\Notifications\Notification;
use Filament\Tables\Actions\Action;

class ReleaseAdminReleaseDividends extends ReleaseDividends
{
    protected function getTableActions()
    {
        return [
            Action::make('transfer')
                ->button()
                ->label('Transfer')
                ->color('primary')
                ->action(function ($data, $record) {
                    $record->update([
                        'user_id' => $data['user_id']
                    ]);
                    Notification::make()->title('Dividend transferred')->success()->send();
                })
                ->form([
                    Select::make('user_id')
                        ->label('User')
                        ->options(User::has('member_information')->pluck('full_name', 'id'))
                        ->searchable()
                ]),
        ];
    }

    public function render()
    {
        return view('livewire.release-admin.release-admin-release-dividends');
    }
}
