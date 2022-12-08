<?php

namespace App\Http\Livewire\OfficeStaff;

use Akaunting\Money\Money;
use Livewire\Component;
use App\Models\MemberInformation;
use App\Models\Release;
use App\Models\User;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\Layout;
use Filament\Tables\Filters\SelectFilter;

class OfficeStaffLedgerIndex extends Component implements HasTable
{
    use InteractsWithTable;

    protected function shouldPersistTableFiltersInSession(): bool
    {
        return true;
    }

    protected function getTableQuery()
    {
        return User::has('member_information')
            ->orderBy('surname')
            ->with(['member_information', 'dividends', 'active_restriction']);
    }

    protected function getTableFilters()
    {
        $years = collect(today()->subYears(5)->yearsUntil(today())->toArray())->mapWithKeys(fn ($y) => [$y->year => $y->year])->toArray();
        return [
            SelectFilter::make('status')
                ->options([
                    1 => 'Active',
                    2 => 'Deceased',
                    3 => 'Inactive',
                ])
                ->default(MemberInformation::STATUS_ACTIVE)
                ->label('Member Status')
                ->query(function ($query, $state) {
                    $query->when($state['value'], fn ($query) => $query->whereRelation('member_information', 'status', $state));
                }),
            SelectFilter::make('created_at')
                ->options($years)
                ->default(today()->year)
                ->label('Year')
                ->query(function ($query, $state) {
                    $query;
                }),
        ];
    }

    protected function getTableColumns()
    {
        return [
            TextColumn::make('member_information.darbc_id')
                ->searchable(),
            TextColumn::make('first_name')
                ->searchable(),
            TextColumn::make('surname')
                ->searchable(),
        ];
    }

    protected function getTableFiltersLayout(): ?string
    {
        return Layout::AboveContent;
    }

    public function getTableContent()
    {
        return view('livewire.office-staff.components.ledger-releases-table', [
            'releases' => Release::query()
                ->when($this->tableFilters['created_at']['value'], fn ($q) => $q->whereYear('created_at', $this->tableFilters['created_at']['value']))
                ->get(),
        ]);
    }

    public function render()
    {
        return view('livewire.office-staff.office-staff-ledger-index');
    }
}
