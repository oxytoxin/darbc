<?php

namespace App\Filament\Resources\MemberInformationResource\Pages;

use App\Filament\Resources\MemberInformationResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListMemberInformation extends ListRecords
{
    protected static string $resource = MemberInformationResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
