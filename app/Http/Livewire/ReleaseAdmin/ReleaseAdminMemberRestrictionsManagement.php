<?php

namespace App\Http\Livewire\ReleaseAdmin;

use App\Models\MemberInformation;
use App\Models\Restriction;
use Filament\Forms\Components\TagsInput;
use Filament\Notifications\Notification;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\CreateAction;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TagsColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Livewire\Component;

class ReleaseAdminMemberRestrictionsManagement extends Component implements HasTable
{
    use InteractsWithTable;

    public MemberInformation $member;

    protected function getTableQuery()
    {
        return Restriction::whereUserId($this->member->user_id);
    }

    protected function getTableColumns()
    {
        return [
            TagsColumn::make('entries')
                ->label('Restrictions'),
            TextColumn::make('created_at')
                ->date()
                ->label('Date Added'),
            IconColumn::make('active')
                ->boolean(),
        ];
    }

    protected function getTableHeaderActions(): array
    {
        return [
            CreateAction::make('create')
                ->icon('heroicon-o-plus')
                ->disableCreateAnother()
                ->form([
                    TagsInput::make('entries')
                        ->label('Restrictions (Press Enter for each entry)')
                        ->placeholder('Enter a restriction')
                        ->suggestions([
                            'Bad Standing',
                            'Court Hearing',
                            'Proceedings'
                        ])
                ])
                ->action(function ($data) {
                    $this->validate();
                    $this->member->user->restrictions()->create([
                        'entries' => $data['entries']
                    ]);
                    Notification::make()->title('Restriction added successfully.')->success()->send();
                })
                ->modalWidth('md'),
        ];
    }

    protected function getTableActions()
    {
        return [
            Action::make('activate')
                ->button()
                ->color('success')
                ->action(fn ($record) => $record->update(['active' => true]))
                ->visible(fn ($record) => !$record->active),
            Action::make('deactivate')
                ->button()
                ->color('danger')
                ->action(fn ($record) => $record->update(['active' => false]))
                ->visible(fn ($record) => $record->active),
            DeleteAction::make('delete'),
        ];
    }


    public function render()
    {
        return view('livewire.release-admin.release-admin-member-restrictions-management');
    }
}
