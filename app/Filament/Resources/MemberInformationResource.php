<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Resources\Form;
use Filament\Resources\Table;
use Filament\Resources\Resource;
use App\Models\MemberInformation;
use Filament\Tables\Actions\Position;
use App\Filament\Resources\MemberInformationResource\Pages;
use App\Models\Gender;
use App\Models\MembershipStatus;
use App\Models\Occupation;
use Awcodes\FilamentTableRepeater\Components\TableRepeater;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\TextInput;
use Str;

class MemberInformationResource extends Resource
{
    protected static ?string $model = MemberInformation::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Fieldset::make('user_details')
                    ->label('User Details')
                    ->schema([
                        TextInput::make('first_name')
                            ->required()
                            ->maxLength(191),
                        TextInput::make('middle_name')
                            ->maxLength(191),
                        TextInput::make('surname')
                            ->required()
                            ->maxLength(191),
                        TextInput::make('suffix')
                            ->maxLength(191),
                    ]),
                Forms\Components\Select::make('original_member_id')
                    ->label('Original Member ID')
                    ->relationship('original_member', 'full_name')
                    ->reactive()
                    ->afterStateUpdated(function ($set, $state) {
                        $member = MemberInformation::firstWhere('user_id', $state);
                        $set('darbc_id', $member->darbc_id);
                        $set('cluster_id', $member->cluster_id);
                        $set('lineage_identifier', $member->lineage_identifier);
                        $set('succession_number', $member->succession_number + 1);
                    })
                    ->searchable(),
                Forms\Components\TextInput::make('succession_number')
                    ->default(0)
                    ->required(),
                Forms\Components\TextInput::make('lineage_identifier')
                    ->default(Str::random(10))
                    ->maxLength(191),
                Forms\Components\TextInput::make('reference_number')
                    ->maxLength(191),
                Forms\Components\Select::make('cluster_id')->relationship('cluster', 'name'),
                Forms\Components\Select::make('gender_id')
                    ->relationship('gender', 'name')
                    ->default(Gender::UNKNOWN)
                    ->required(),
                Forms\Components\TextInput::make('darbc_id')
                    ->label('DARBC ID')
                    ->required(),
                Forms\Components\Select::make('membership_status_id')
                    ->relationship('membership_status', 'name')
                    ->default(MembershipStatus::REPLACEMENT)
                    ->required(),
                Forms\Components\Toggle::make('is_darbc_member')
                    ->default(false)
                    ->required(),
                Forms\Components\Toggle::make('split_claim')
                    ->default(false)
                    ->required(),
                Forms\Components\Select::make('status')
                    ->options([
                        MemberInformation::STATUS_ACTIVE => 'Active',
                        MemberInformation::STATUS_DECEASED => 'Deceased',
                        MemberInformation::STATUS_INACTIVE => 'Inactive',
                    ])
                    ->default(MemberInformation::STATUS_ACTIVE)
                    ->required(),
                Forms\Components\Select::make('occupation_id')
                    ->relationship('occupation', 'name')
                    ->default(Occupation::UNKNOWN)
                    ->required(),
                Forms\Components\TextInput::make('percentage')
                    ->default(100)
                    ->numeric()
                    ->required(),
                Forms\Components\TextInput::make('religion')
                    ->maxLength(191),
                Forms\Components\DatePicker::make('date_of_birth'),
                Forms\Components\TextInput::make('blood_type')
                    ->maxLength(191),
                Forms\Components\Textarea::make('place_of_birth')
                    ->maxLength(65535),
                Forms\Components\Textarea::make('occupation_details')
                    ->maxLength(65535),
                Forms\Components\TextInput::make('province_code')
                    ->maxLength(191),
                Forms\Components\TextInput::make('region_code')
                    ->maxLength(191),
                Forms\Components\TextInput::make('city_code')
                    ->maxLength(191),
                Forms\Components\TextInput::make('barangay_code')
                    ->maxLength(191),
                Forms\Components\TextInput::make('address_line')
                    ->maxLength(512),
                Forms\Components\Select::make('civil_status')
                    ->options([
                        MemberInformation::CS_SINGLE => 'Single',
                        MemberInformation::CS_MARRIED => 'Married',
                        MemberInformation::CS_WIDOW => 'Widowed',
                        MemberInformation::CS_LEGALLY_SEPARATED => 'Legally Separated',
                        MemberInformation::CS_UNKNOWN => 'Unknown',
                    ])
                    ->default(MemberInformation::CS_UNKNOWN)
                    ->required(),
                Forms\Components\TextInput::make('mother_maiden_name')
                    ->maxLength(191),
                Forms\Components\TextInput::make('spouse')
                    ->maxLength(191),
                TableRepeater::make('children')
                    ->label('Children')
                    ->schema([
                        Forms\Components\TextInput::make('name')->required()->disableLabel(),
                        Forms\Components\DatePicker::make('date_of_birth')->required()->disableLabel()->withoutTime(),
                        Forms\Components\TextInput::make('educational_attainment')->required()->disableLabel(),
                        Forms\Components\TextInput::make('blood_type')->required()->disableLabel(),
                    ])
                    ->disableItemMovement(),
                Forms\Components\TextInput::make('sss_number')
                    ->maxLength(191),
                Forms\Components\TextInput::make('philhealth_number')
                    ->maxLength(191),
                Forms\Components\TextInput::make('tin_number')
                    ->maxLength(191),
                Forms\Components\TextInput::make('contact_number')
                    ->maxLength(191),
                TagsInput::make('spa')->placeholder('New SPA (first-name last-name)'),
                Forms\Components\DatePicker::make('application_date')
                    ->default(today()),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user_id')->label('UID')->searchable(),
                Tables\Columns\TextColumn::make('user.full_name')->searchable(['surname', 'first_name']),
                Tables\Columns\TextColumn::make('cluster.name'),
                Tables\Columns\TextColumn::make('original_member_id')->label('Original'),
                Tables\Columns\TextColumn::make('membership_status.name'),
                Tables\Columns\IconColumn::make('is_darbc_member')
                    ->label('DARBC MEMBER')
                    ->boolean(),
                Tables\Columns\IconColumn::make('split_claim')
                    ->boolean(),
                Tables\Columns\TextColumn::make('status')
                    ->enum([
                        MemberInformation::STATUS_ACTIVE => 'Active',
                        MemberInformation::STATUS_DECEASED => 'Deceased',
                        MemberInformation::STATUS_INACTIVE => 'Inactive',
                    ]),
                Tables\Columns\TextColumn::make('darbc_id')->label('DARBC ID'),
                Tables\Columns\TextColumn::make('reference_number'),
                Tables\Columns\TextColumn::make('percentage'),
                Tables\Columns\TextColumn::make('succession_number'),
                Tables\Columns\TextColumn::make('lineage_identifier'),
                Tables\Columns\TextColumn::make('application_date')
                    ->date(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([])->actionsPosition(Position::BeforeCells);
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
            'index' => Pages\ListMemberInformation::route('/'),
            'create' => Pages\CreateMemberInformation::route('/create'),
            'edit' => Pages\EditMemberInformation::route('/{record}/edit'),
        ];
    }
}
