<?php

namespace App\View\Components;

use Filament\Tables\Columns\BadgeColumn;
use Illuminate\View\Component;

class FreeLotStatusColumn extends BadgeColumn
{
    protected string $view = 'components.custom-columns.free-lot-status-column';
}
