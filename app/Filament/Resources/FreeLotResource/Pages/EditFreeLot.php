<?php

namespace App\Filament\Resources\FreeLotResource\Pages;

use App\Filament\Resources\FreeLotResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;
use Str;

class EditFreeLot extends EditRecord
{
    protected static string $resource = FreeLotResource::class;

    protected function mutateFormDataBeforeFill(array $data): array
    {
        if (!is_null($data['swapping_history'])) {
            foreach ($data['swapping_history'] as $key => $history) {
                $d = [];
                $d['date'] = $history['date'];
                $d['origin_cluster_id'] = $history['origin']['cluster_id'];
                $d['origin_block'] = $history['origin']['block'];
                $d['origin_lot'] = $history['origin']['lot'];
                $d['origin_area'] = $history['origin']['area'];
                $d['origin_owner'] = $history['origin']['owner'];
                $d['origin_owner_id'] = $history['origin']['owner_id'];
                $d['target_cluster_id'] = $history['target']['cluster_id'];
                $d['target_block'] = $history['target']['block'];
                $d['target_lot'] = $history['target']['lot'];
                $d['target_area'] = $history['target']['area'];
                $d['target_owner'] = $history['target']['owner'];
                $d['target_owner_id'] = $history['target']['owner_id'];
                $data['swapping'][Str::random(8)] = $d;
            }
        }
        return $data;
    }

    protected function handleRecordUpdate(Model $record, array $data): Model
    {
        $new_swapping = [];
        foreach ($data['swapping'] as $key => $swapping_data) {
            $new_swapping[] = [
                'date' => $swapping_data['date'],
                'origin' => [
                    'cluster_id' => $swapping_data['origin_cluster_id'],
                    'block' => $swapping_data['origin_block'],
                    'lot' => $swapping_data['origin_lot'],
                    'area' => $swapping_data['origin_area'],
                    'owner' => $swapping_data['origin_owner'],
                    'owner_id' => $swapping_data['origin_owner_id'],
                ],
                'target' => [
                    'cluster_id' => $swapping_data['target_cluster_id'],
                    'block' => $swapping_data['target_block'],
                    'lot' => $swapping_data['target_lot'],
                    'area' => $swapping_data['target_area'],
                    'owner' => $swapping_data['target_owner'],
                    'owner_id' => $swapping_data['target_owner_id'],
                ],
            ];
        }

        $record->update([
            'swapping_history' => $new_swapping,
        ]);

        return $record;
    }

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
