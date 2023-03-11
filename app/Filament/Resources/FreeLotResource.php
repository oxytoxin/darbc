<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\FreeLot;
use Filament\Resources\Form;
use Filament\Resources\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\KeyValue;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;
use App\View\Components\FreeLotStatusColumn;
use App\Filament\Resources\FreeLotResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\FreeLotResource\RelationManagers;
use App\Models\Cluster;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Filters\SelectFilter;

class FreeLotResource extends Resource
{
    protected static ?string $model = FreeLot::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Repeater::make('swapping')
                    ->schema([
                        DatePicker::make('date')->label('Date'),
                        Fieldset::make('Origin')
                            ->schema([
                                Select::make('origin_cluster_id')->options(Cluster::pluck('name', 'id'))->label('Cluster'),
                                TextInput::make('origin_block')->label('Block'),
                                TextInput::make('origin_lot')->label('Lot'),
                                TextInput::make('origin_area')->label('Area'),
                                TextInput::make('origin_owner')->label('Owner Name'),
                                TextInput::make('origin_owner_id')->label('Owner User Id'),
                            ]),
                        Fieldset::make('Target')
                            ->schema([
                                Select::make('target_cluster_id')->options(Cluster::pluck('name', 'id'))->label('Cluster'),
                                TextInput::make('target_block')->label('Block'),
                                TextInput::make('target_lot')->label('Lot'),
                                TextInput::make('target_area')->label('Area'),
                                TextInput::make('target_owner')->label('Owner Name'),
                                TextInput::make('target_owner_id')->label('Owner User Id'),
                            ]),
                    ])
            ])->columns(1);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.full_name')->label('Member'),
                FreeLotStatusColumn::make('status')
                    ->enum([
                        1 => '',
                        2 => 'SOLD',
                        3 => 'RELOCATED',
                        4 => 'SWAPPED',
                    ])
                    ->size('sm')
                    ->colors([
                        'active' => 1,
                        'sold' => 2,
                        'relocated' => 3,
                        'swapped' => 4,
                    ])
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->options([
                        1 => 'ACTIVE',
                        2 => 'SOLD',
                        3 => 'RELOCATED',
                        4 => 'SWAPPED',
                    ])
                    ->placeholder('All'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListFreeLots::route('/'),
            'create' => Pages\CreateFreeLot::route('/create'),
            'edit' => Pages\EditFreeLot::route('/{record}/edit'),
        ];
    }
}
