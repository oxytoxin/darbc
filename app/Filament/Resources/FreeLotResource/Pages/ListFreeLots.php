<?php

namespace App\Filament\Resources\FreeLotResource\Pages;

use App\Filament\Resources\FreeLotResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListFreeLots extends ListRecords
{
    protected static string $resource = FreeLotResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
