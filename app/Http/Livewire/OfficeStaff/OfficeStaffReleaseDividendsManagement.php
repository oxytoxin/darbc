<?php

namespace App\Http\Livewire\OfficeStaff;

use App\Models\Dividend;
use App\Models\MemberInformation;
use App\Models\Release;
use App\Models\User;
use DB;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Notifications\Notification;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TagsColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Illuminate\Support\HtmlString;
use Livewire\Component;

class OfficeStaffReleaseDividendsManagement extends Component implements HasTable
{
    use InteractsWithTable;

    public $amount = 0;
    public $restrict_by_default = false;
    public Release $release;

    protected function getTableQuery()
    {
        return Dividend::with(['user.member_information'])->whereReleaseId($this->release->id);
    }

    protected function getFormSchema()
    {
        return [
            Toggle::make('restrict_by_default')
                ->label('Automatically enter member restrictions on dividends'),
            TextInput::make('amount')
                ->minValue(0)
                ->placeholder('0.00')
                ->numeric()
                ->label('Enter initial amount applicable for majority of members.')
                ->required(),
        ];
    }

    protected function getTableColumns()
    {
        return [
            TextColumn::make('user.member_information.darbc_id')
                ->label('DARBC ID')
                ->searchable(),
            TextColumn::make('user.member_information.percentage')
                ->label('Percentage'),
            TextColumn::make('user.surname')
                ->label('Last Name')
                ->sortable()
                ->searchable(isIndividual: true),
            TextColumn::make('user.first_name')
                ->label('First Name')
                ->searchable(isIndividual: true),
            TextColumn::make('gross_amount')
                ->sortable()
                ->label('Gross')
                ->searchable()
                ->money('PHP', true),
            TextColumn::make('deductions_amount')
                ->sortable()
                ->label('Deductions')
                ->money('PHP', true),
            TextColumn::make('net_amount')
                ->label('Net')
                ->money('PHP', true),
            TagsColumn::make('restriction_entries')
                ->sortable()
                ->label('Restrictions'),
        ];
    }

    protected function getTableActions()
    {
        return [
            EditAction::make('edit')
                ->action(function ($record, $data) {
                    $record->update($data);
                    Notification::make()->title('Dividend updated successfully.')->success()->send();
                })
                ->mountUsing(function ($form, Dividend $record) {
                    $form->fill([
                        'gross_amount' => $record->gross_amount,
                        'deductions_amount' => $record->deductions_amount,
                        'restriction_entries' => count($record->restriction_entries ?? []) ? $record->restriction_entries : $record->user->active_restriction?->entries,
                    ]);
                })
                ->form([
                    TextInput::make('gross_amount')
                        ->numeric()
                        ->required()
                        ->minValue(0),
                    TextInput::make('deductions_amount')
                        ->numeric()
                        ->required()
                        ->minValue(0)
                        ->lte('gross_amount'),
                    TagsInput::make('restriction_entries')
                        ->label('Restrictions (Press Enter for each entry)')
                        ->placeholder('Enter a restriction')
                ])
        ];
    }

    protected function getDefaultTableSortColumn(): ?string
    {
        return 'user_id';
    }

    protected function getDefaultTableSortDirection(): ?string
    {
        return 'asc';
    }

    public function render()
    {
        return view('livewire.office-staff.office-staff-release-dividends-management', [
            'dividends_net_amount' => ($this->release->pending_dividends()->sum('gross_amount') / 100) - $this->release->pending_dividends()->sum('deductions_amount') / 100,
        ]);
    }

    public function generateDividends()
    {
        $this->form->validate();
        DB::beginTransaction();
        $this->release->pending_dividends()->delete();

        $data = collect();
        $users = User::with(['active_restriction', 'member_information'])->whereRelation('member_information', 'status', MemberInformation::STATUS_ACTIVE)->get();
        $now = now();
        $particulars = json_encode(collect($this->release->particulars)->flatMap(fn ($particular, $key) => [$key => ''])->toArray());
        foreach ($users as $user) {
            if ($this->restrict_by_default) {
                $restrictions = $user->active_restriction?->entries ?? [];
            }
            $data->push([
                'release_id' => $this->release->id,
                'user_id' => $user->id,
                'gross_amount' => $this->amount * $user->member_information->percentage,
                'status' => Dividend::PENDING,
                'particulars' => $particulars,
                'restriction_entries' => json_encode($restrictions ?? []),
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }

        $data->chunk(1000)->each(function ($chunk) {
            Dividend::insert($chunk->toArray());
        });

        DB::commit();
        Notification::make()->title('Dividends regenerated.')->success()->send();
    }

    public function clearDividends()
    {
        $this->release->pending_dividends()->delete();
        Notification::make()->title('Pending dividends cleared.')->success()->send();
    }

    public function clearRestrictions()
    {
        $this->release->pending_dividends()->update([
            'restriction_entries' => json_encode([]),
        ]);
        Notification::make()->title('Dividend restrictions cleared.')->success()->send();
    }

    public function clearDeductions()
    {
        $this->release->pending_dividends()->update([
            'deductions_amount' => 0,
        ]);
        Notification::make()->title('Dividend deductions cleared.')->success()->send();
    }

    public function finalize()
    {
        $restricted_dividends = $this->release->pending_dividends()->whereJsonLength('restriction_entries', '>', 0);
        $regular_dividends = $this->release->pending_dividends()->whereJsonLength('restriction_entries', 0);
        DB::beginTransaction();
        $restricted_dividends->update([
            'status' => Dividend::ON_HOLD,
        ]);
        $regular_dividends->update([
            'status' => Dividend::FOR_RELEASE,
        ]);
        $this->release->update([
            'disbursed' => true
        ]);
        DB::commit();
        Notification::make()->title('Dividends disbursed.')->success()->send();
        return redirect()->route('office-staff.ledger.index');
    }
}
