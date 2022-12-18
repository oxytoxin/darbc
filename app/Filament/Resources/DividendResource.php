<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Dividend;
use Filament\Resources\Form;
use Filament\Resources\Table;
use Filament\Resources\Resource;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Actions\DeleteBulkAction;
use App\Filament\Resources\DividendResource\Pages;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use App\Filament\Resources\DividendResource\Pages\EditDividend;
use App\Filament\Resources\DividendResource\Pages\ListDividends;

class DividendResource extends Resource
{
    protected static ?string $model = Dividend::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                SpatieMediaLibraryFileUpload::make('proof_of_release')
                    ->collection('proof_of_release')
                    ->enableOpen()
                    ->disk('proof_of_release')
                    ->image(),
                Forms\Components\TextInput::make('gift_certificate_control_number')
                    ->maxLength(191),
                Forms\Components\TextInput::make('claimed_by')
                    ->maxLength(191),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('release.name')
                    ->limit(10)
                    ->tooltip(fn ($record) => $record->release->name),
                Tables\Columns\TextColumn::make('user.full_name')
                    ->searchable(['surname', 'first_name'])
                    ->label('Member'),
                Tables\Columns\TextColumn::make('cashier.name'),
                Tables\Columns\TextColumn::make('gross_amount')->money('PHP', true),
                Tables\Columns\TextColumn::make('deductions_amount')->money('PHP', true),
                BadgeColumn::make('status')
                    ->label('Status')
                    ->sortable()
                    ->colors([
                        'primary',
                        'success' => Dividend::FOR_RELEASE,
                        'danger' => Dividend::ON_HOLD,
                    ])
                    ->enum([
                        Dividend::FOR_RELEASE => 'for release',
                        Dividend::ON_HOLD => 'on hold',
                        Dividend::RELEASED => 'released',
                    ])
                    ->alignCenter(),
                Tables\Columns\IconColumn::make('voided')
                    ->boolean(),
                Tables\Columns\IconColumn::make('claimed')
                    ->boolean(),
                Tables\Columns\TextColumn::make('restriction_entries'),
                Tables\Columns\TextColumn::make('released_at')
                    ->dateTime(),
                Tables\Columns\TextColumn::make('gift_certificate_control_number'),
                Tables\Columns\TextColumn::make('claimed_by'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListDividends::route('/'),
            'edit' => Pages\EditDividend::route('/{record}/edit'),
        ];
    }
}
