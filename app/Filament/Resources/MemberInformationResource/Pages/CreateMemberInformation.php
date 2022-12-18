<?php

namespace App\Filament\Resources\MemberInformationResource\Pages;

use DB;
use App\Models\User;
use Filament\Pages\Actions;
use Illuminate\Support\Str;
use App\Models\MemberInformation;
use Filament\Resources\Pages\CreateRecord;
use App\Filament\Resources\MemberInformationResource;

class CreateMemberInformation extends CreateRecord
{
    protected static string $resource = MemberInformationResource::class;

    protected function handleRecordCreation(array $data): MemberInformation
    {
        DB::beginTransaction();
        $user_data = [
            "first_name" => $data["first_name"],
            "middle_name" => $data["middle_name"],
            "surname" => $data["surname"],
            "suffix" => $data["suffix"],
            "username" => str($data["first_name"] . ' ' . $data["surname"] . ' ' . Str::random(5))->slug('-'),
            "password" => bcrypt(now()->timestamp)
        ];
        unset($data["first_name"]);
        unset($data["middle_name"]);
        unset($data["surname"]);
        unset($data["suffix"]);
        $user = User::create($user_data);
        $data["user_id"] = $user->id;
        $member = MemberInformation::create($data);
        DB::commit();
        return $member;
    }
}
