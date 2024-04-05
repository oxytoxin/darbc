<?php

namespace App\Http\Livewire\Cashier;

use App\Models\Payslip;
use App\Models\Release;
use Filament\Forms\Components\Select;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\CreateAction;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Livewire\Component;

class CashierPayslipsIndex extends Component implements HasTable
{
    use InteractsWithTable;

    protected function getTableQuery()
    {
        return Payslip::query();
    }

    protected function getTableColumns()
    {
        return [
            TextColumn::make('release.name'),
        ];
    }

    protected function getTableHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->form([
                    Select::make('release_id')
                        ->label('Release')
                        ->options(Release::latest()->pluck('name', 'id'))
                ])
        ];
    }

    protected function getTableActions(): array
    {
        return [
            EditAction::make()
                ->form([
                    Select::make('release_id')
                        ->label('Release')
                        ->options(Release::latest()->pluck('name', 'id'))
                ]),
            DeleteAction::make(),
            Action::make('payslips')
                ->url(fn ($record) => route('cashier.payslips.entries', ['payslip' => $record]), true)
                ->button()
                ->color('success')
        ];
    }

    public function render()
    {
        return view('livewire.cashier.cashier-payslips-index');
    }
}
