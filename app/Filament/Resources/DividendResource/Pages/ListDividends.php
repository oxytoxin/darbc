<?php

namespace App\Filament\Resources\DividendResource\Pages;

use App\Filament\Resources\DividendResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListDividends extends ListRecords
{
    protected static string $resource = DividendResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
