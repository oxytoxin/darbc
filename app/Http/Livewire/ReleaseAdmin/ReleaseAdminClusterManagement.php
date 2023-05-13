<?php

namespace App\Http\Livewire\ReleaseAdmin;

use App\Http\Livewire\Shared\ClusterManagement;
use App\Models\User;
use App\Models\Cluster;
use Livewire\Component;
use Filament\Forms\Components\Select;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Contracts\HasTable;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Actions\CreateAction;
use Filament\Tables\Concerns\InteractsWithTable;

class ReleaseAdminClusterManagement extends ClusterManagement
{
}
