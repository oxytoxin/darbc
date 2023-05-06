<?php

namespace App\Http\Livewire\Cashier;

use App\Models\User;
use App\Models\Release;
use Livewire\Component;
use App\Models\Dividend;
use Filament\Tables\Actions\Action;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\Layout;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Contracts\HasTable;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Concerns\InteractsWithTable;

class CashierReleasedDividendsHistory extends Component implements HasTable
{
    use InteractsWithTable;

    protected function getTableRecordsPerPageSelectOptions(): array
    {
        return [5, 10, 25, 50];
    }

    protected function getTableQuery()
    {
        return Dividend::with('user.member_information')->whereNotNull('released_by')->latest('released_at');
    }

    protected function getTableColumns()
    {
        return [
            TextColumn::make('released_at')
                ->label('Release Date')
                ->dateTime('h:i A m/d/Y')
                ->size('sm')
                ->wrap(),
            TextColumn::make('release.name')
                ->label('Release')
                ->size('sm')
                ->wrap(),
            TextColumn::make('user.member_information.darbc_id')
                ->label('DARBC ID')
                ->searchable(),
            TextColumn::make('cashier.full_name')
                ->label('Cashier'),
            TextColumn::make('user.surname')
                ->label('Member Last Name')
                ->searchable(isIndividual: true),
            TextColumn::make('user.first_name')
                ->label('Member First Name')
                ->searchable(isIndividual: true),

        ];
    }

    protected function getTableActions()
    {
        return [
            Action::make('Payslip')
                ->icon('heroicon-o-document-report')
                ->button()
                ->url(fn (Dividend $record) => route('cashier.dividends.payslip', ['dividend' => $record])),
        ];
    }

    protected function getTableFilters(): array
    {
        return [
            Filter::make('released_at')
                ->form([
                    DatePicker::make('released_from'),
                    DatePicker::make('released_until'),
                ])
                ->query(function (Builder $query, array $data): Builder {
                    return $query
                        ->when(
                            $data['released_from'],
                            fn (Builder $query, $date): Builder => $query->whereDate('released_at', '>=', $date),
                        )
                        ->when(
                            $data['released_until'],
                            fn (Builder $query, $date): Builder => $query->whereDate('released_at', '<=', $date),
                        );
                }),
            SelectFilter::make('released_by')
                ->label('Cashier')
                ->placeholder('All')
                ->options(User::whereRelation('roles', 'name', 'cashier')->get()->pluck('full_name', 'id')),
            SelectFilter::make('release_id')
                ->label('Release')
                ->placeholder('All')
                ->options(Release::pluck('name', 'id')),
        ];
    }

    protected function getTableFiltersLayout(): ?string
    {
        return Layout::AboveContent;
    }

    public function render()
    {
        return view('livewire.cashier.cashier-released-dividends-history');
    }
}
