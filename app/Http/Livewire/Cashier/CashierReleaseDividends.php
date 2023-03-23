<?php

namespace App\Http\Livewire\Cashier;

use Livewire\Component;
use App\Models\Dividend;
use App\Models\MemberInformation;
use Filament\Tables\Actions\Action;
use Filament\Tables\Filters\Layout;
use Filament\Tables\Columns\TagsColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Filters\SelectFilter;
use App\Http\Livewire\Shared\ReleaseDividends;
use Filament\Tables\Concerns\InteractsWithTable;

class CashierReleaseDividends extends ReleaseDividends
{
    protected function shouldPersistTableFiltersInSession(): bool
    {
        return true;
    }

    protected function getTableActions()
    {
        return [
            Action::make('release')
                ->button()
                ->label('Release Now')
                ->color('success')
                ->visible(fn ($record) => $record->status === Dividend::FOR_RELEASE && !$record->claimed)
                ->url(fn ($record) => route('cashier.dividends.manage', ['dividend' => $record])),
        ];
    }

    public function render()
    {
        return view('livewire.cashier.cashier-release-dividends');
    }
}
