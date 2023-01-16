<?php

namespace App\Filament\Resources\MemberInformationResource\Pages;

use DB;
use App\Models\User;
use Filament\Pages\Actions;
use Illuminate\Support\Str;
use App\Models\MemberInformation;
use Illuminate\Database\Eloquent\Model;
use Filament\Notifications\Notification;
use Filament\Pages\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use App\Filament\Resources\MemberInformationResource;

class EditMemberInformation extends EditRecord
{
    protected static string $resource = MemberInformationResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make()
                ->action(function ($record) {
                    $record->delete();
                    $record->user->delete();
                    Notification::make('Member deleted successfully.')->success()->send();
                    return redirect(self::$resource::getUrl('index'));
                }),
        ];
    }

    protected function handleRecordUpdate(Model $record, array $data): MemberInformation
    {
        DB::beginTransaction();
        $user_data = [
            "first_name" => $data["first_name"],
            "middle_name" => $data["middle_name"],
            "surname" => $data["surname"],
            "suffix" => $data["suffix"],
        ];
        unset($data["first_name"]);
        unset($data["middle_name"]);
        unset($data["surname"]);
        unset($data["suffix"]);
        $data["reference_number"] = $data["darbc_id"];
        $record->user()->update($user_data);
        $record->update($data);
        DB::commit();
        return $record;
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        $this->record->load('user');
        $data['first_name'] = $this->record->user->first_name;
        $data['middle_name'] = $this->record->user->middle_name;
        $data['surname'] = $this->record->user->surname;
        $data['suffix'] = $this->record->user->suffix;
        return $data;
    }
}
