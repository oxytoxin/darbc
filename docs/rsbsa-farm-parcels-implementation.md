# RSBSA Farm Parcels Implementation Plan

## Overview

This document outlines the proposed changes to complete the RSBSA form by adding the **Farm Parcels section (Page 2)** of the official DA RSBSA Enrollment Form.

## Why This Is Needed

The current RSBSA implementation covers:
- Part I: Personal Information (Complete)
- Part II: Farm Profile (Complete)

Missing:
- **Farm Parcels Section** - Documents land ownership details for up to 3 farm parcels

Since DARBC members are Agrarian Reform Beneficiaries with land holdings, this section is relevant for complete RSBSA registration.

---

## Database Changes

### 1. New Table: `rsbsa_farm_parcels`

```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('rsbsa_farm_parcels', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('rsbsa_record_id');
            $table->foreign('rsbsa_record_id')
                  ->references('id')
                  ->on('rsbsa_records')
                  ->onDelete('cascade');

            $table->integer('parcel_no')->default(1); // 1, 2, or 3

            // Farm Location
            $table->string('farm_location_barangay')->nullable();
            $table->string('farm_location_municipality')->nullable();

            // Farm Area & Ownership
            $table->decimal('total_farm_area_hectares', 10, 4)->nullable();
            $table->boolean('is_within_ancestral_domain')->default(false);
            $table->string('ownership_document_no')->nullable();
            $table->integer('ownership_document_type')->nullable(); // 1-13 from list
            $table->boolean('is_agrarian_reform_beneficiary')->default(false);

            // Ownership Type
            $table->enum('ownership_type', [
                'Registered Owner',
                'Tenant',
                'Lessee',
                'Others'
            ])->nullable();
            $table->string('ownership_type_others')->nullable();
            $table->string('land_owner_name')->nullable(); // For Tenant/Lessee

            // Crop/Commodity Details (for the table)
            $table->string('farm_land_description')->nullable();
            $table->string('crop_commodity')->nullable(); // Rice/Corn/HVC/Livestock/Poultry/Agri-fishery
            $table->string('crop_commodity_specify')->nullable(); // For Livestock & Poultry type
            $table->decimal('size_hectares', 10, 4)->nullable();
            $table->integer('no_of_head')->nullable(); // For Livestock/Poultry
            $table->integer('farm_type')->nullable(); // 1-Irrigated, 2-Rainfed Upland, 3-Rainfed Lowland
            $table->boolean('is_organic_practitioner')->default(false);
            $table->text('remarks')->nullable();

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('rsbsa_farm_parcels');
    }
};
```

### 2. Additional Columns for `rsbsa_records`

```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('rsbsa_records', function (Blueprint $table) {
            $table->integer('no_of_farm_parcels')->default(0)->after('gross_annual_income_nonfarming');
            $table->string('farmer_rotation_p1')->nullable()->after('no_of_farm_parcels');
            $table->string('farmer_rotation_p2')->nullable()->after('farmer_rotation_p1');
            $table->string('farmer_rotation_p3')->nullable()->after('farmer_rotation_p2');
        });
    }

    public function down()
    {
        Schema::table('rsbsa_records', function (Blueprint $table) {
            $table->dropColumn([
                'no_of_farm_parcels',
                'farmer_rotation_p1',
                'farmer_rotation_p2',
                'farmer_rotation_p3',
            ]);
        });
    }
};
```

---

## Model Changes

### 1. New Model: `RsbsaFarmParcel.php`

```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RsbsaFarmParcel extends Model
{
    use HasFactory;

    protected $fillable = [
        'rsbsa_record_id',
        'parcel_no',
        'farm_location_barangay',
        'farm_location_municipality',
        'total_farm_area_hectares',
        'is_within_ancestral_domain',
        'ownership_document_no',
        'ownership_document_type',
        'is_agrarian_reform_beneficiary',
        'ownership_type',
        'ownership_type_others',
        'land_owner_name',
        'farm_land_description',
        'crop_commodity',
        'crop_commodity_specify',
        'size_hectares',
        'no_of_head',
        'farm_type',
        'is_organic_practitioner',
        'remarks',
    ];

    protected $casts = [
        'is_within_ancestral_domain' => 'boolean',
        'is_agrarian_reform_beneficiary' => 'boolean',
        'is_organic_practitioner' => 'boolean',
        'total_farm_area_hectares' => 'decimal:4',
        'size_hectares' => 'decimal:4',
    ];

    /**
     * Ownership Document Types
     */
    public const OWNERSHIP_DOCUMENT_TYPES = [
        1 => 'Certificate of Land Transfer',
        2 => 'Emancipation Patent',
        3 => 'Individual Certificate of Land Ownership Award (CLOA)',
        4 => 'Collective CLOA',
        5 => 'Co-ownership CLOA',
        6 => 'Agricultural sales patent',
        7 => 'Homestead patent',
        8 => 'Free Patent',
        9 => 'Certificate of Title or Regular Title',
        10 => 'Certificate of Ancestral Domain Title',
        11 => 'Certificate of Ancestral Land Title',
        12 => 'Tax Declaration',
        13 => 'Others (e.g. Barangay Certification)',
    ];

    /**
     * Farm Types
     */
    public const FARM_TYPES = [
        1 => 'Irrigated',
        2 => 'Rainfed Upland',
        3 => 'Rainfed Lowland',
    ];

    /**
     * Crop/Commodity Options
     */
    public const CROP_COMMODITIES = [
        'Rice',
        'Corn',
        'HVC', // High Value Crops
        'Livestock',
        'Poultry',
        'Agri-fishery',
    ];

    public function rsbsaRecord()
    {
        return $this->belongsTo(RsbsaRecord::class);
    }

    public function getOwnershipDocumentTypeName(): ?string
    {
        return self::OWNERSHIP_DOCUMENT_TYPES[$this->ownership_document_type] ?? null;
    }

    public function getFarmTypeName(): ?string
    {
        return self::FARM_TYPES[$this->farm_type] ?? null;
    }
}
```

### 2. Update `RsbsaRecord.php` Model

Add to the `$fillable` array:
```php
'no_of_farm_parcels',
'farmer_rotation_p1',
'farmer_rotation_p2',
'farmer_rotation_p3',
```

Add relationship method:
```php
public function farmParcels()
{
    return $this->hasMany(RsbsaFarmParcel::class)->orderBy('parcel_no');
}
```

---

## Form Changes

### Add New Step to Form Wizard (RsbsaFroms.php)

```php
// Add this as Step 4 in the wizard

Wizard\Step::make('Farm Parcels')
    ->schema([
        Section::make('Farm Parcel Information')
            ->description('No. of farm parcels and farmers in rotation')
            ->schema([
                Grid::make(4)->schema([
                    TextInput::make('no_of_farm_parcels')
                        ->label('No. of Farm Parcels')
                        ->numeric()
                        ->minValue(0)
                        ->maxValue(3)
                        ->default(0),
                    TextInput::make('farmer_rotation_p1')
                        ->label('Farmer in Rotation (P1)'),
                    TextInput::make('farmer_rotation_p2')
                        ->label('Farmer in Rotation (P2)'),
                    TextInput::make('farmer_rotation_p3')
                        ->label('Farmer in Rotation (P3)'),
                ]),
            ]),

        Section::make('Farm Parcels Details')
            ->description('Enter details for each farm parcel (up to 3)')
            ->schema([
                Repeater::make('farmParcels')
                    ->relationship()
                    ->label('Farm Parcels')
                    ->maxItems(3)
                    ->schema([
                        Grid::make(3)->schema([
                            TextInput::make('parcel_no')
                                ->label('Parcel No.')
                                ->numeric()
                                ->minValue(1)
                                ->maxValue(3)
                                ->required(),
                            TextInput::make('farm_location_barangay')
                                ->label('Farm Location - Barangay'),
                            TextInput::make('farm_location_municipality')
                                ->label('Farm Location - City/Municipality'),
                        ]),

                        Grid::make(4)->schema([
                            TextInput::make('total_farm_area_hectares')
                                ->label('Total Farm Area (hectares)')
                                ->numeric()
                                ->step(0.0001),
                            Toggle::make('is_within_ancestral_domain')
                                ->label('Within Ancestral Domain?')
                                ->inline(false),
                            TextInput::make('ownership_document_no')
                                ->label('Ownership Document No.'),
                            Select::make('ownership_document_type')
                                ->label('Ownership Document Type')
                                ->options(RsbsaFarmParcel::OWNERSHIP_DOCUMENT_TYPES),
                        ]),

                        Grid::make(3)->schema([
                            Toggle::make('is_agrarian_reform_beneficiary')
                                ->label('Agrarian Reform Beneficiary?')
                                ->inline(false),
                            Select::make('ownership_type')
                                ->label('Ownership Type')
                                ->options([
                                    'Registered Owner' => 'Registered Owner',
                                    'Tenant' => 'Tenant',
                                    'Lessee' => 'Lessee',
                                    'Others' => 'Others',
                                ])
                                ->reactive(),
                            TextInput::make('land_owner_name')
                                ->label('Name of Land Owner')
                                ->visible(fn ($get) => in_array($get('ownership_type'), ['Tenant', 'Lessee'])),
                        ]),

                        Fieldset::make('Crop/Commodity Details')
                            ->schema([
                                Grid::make(4)->schema([
                                    TextInput::make('farm_land_description')
                                        ->label('Farm Land Description'),
                                    Select::make('crop_commodity')
                                        ->label('Crop/Commodity')
                                        ->options(array_combine(
                                            RsbsaFarmParcel::CROP_COMMODITIES,
                                            RsbsaFarmParcel::CROP_COMMODITIES
                                        ))
                                        ->reactive(),
                                    TextInput::make('crop_commodity_specify')
                                        ->label('Specify Type')
                                        ->visible(fn ($get) => in_array($get('crop_commodity'), ['Livestock', 'Poultry'])),
                                    TextInput::make('size_hectares')
                                        ->label('Size (ha)')
                                        ->numeric()
                                        ->step(0.0001),
                                ]),
                                Grid::make(4)->schema([
                                    TextInput::make('no_of_head')
                                        ->label('No. of Head')
                                        ->numeric()
                                        ->visible(fn ($get) => in_array($get('crop_commodity'), ['Livestock', 'Poultry'])),
                                    Select::make('farm_type')
                                        ->label('Farm Type')
                                        ->options(RsbsaFarmParcel::FARM_TYPES),
                                    Toggle::make('is_organic_practitioner')
                                        ->label('Organic Practitioner?')
                                        ->inline(false),
                                    TextInput::make('remarks')
                                        ->label('Remarks'),
                                ]),
                            ]),
                    ])
                    ->itemLabel(fn (array $state): ?string =>
                        $state['parcel_no'] ? "Parcel #{$state['parcel_no']}" : null
                    )
                    ->collapsible()
                    ->defaultItems(0)
                    ->addActionLabel('Add Farm Parcel'),
            ]),
    ]),
```

---

## View/Print Changes

Update `view-rsbsa.blade.php` to include the Farm Parcels table with:
- Farm Parcel No.
- Farm Land Description
- Crop/Commodity
- Size (ha)
- No. of Head
- Farm Type
- Organic Practitioner (Y/N)
- Remarks
- Ownership details for each parcel

---

## Implementation Steps

1. [ ] Get boss approval
2. [ ] Run migration: `php artisan make:migration create_rsbsa_farm_parcels_table`
3. [ ] Run migration: `php artisan make:migration add_farm_parcel_fields_to_rsbsa_records_table`
4. [ ] Create model: `app/Models/RsbsaFarmParcel.php`
5. [ ] Update model: `app/Models/RsbsaRecord.php`
6. [ ] Update form: `app/Http/Controllers/Rsbase/RsbsaFroms.php`
7. [ ] Update Livewire components: `CreateRsbsa.php`, `EditRsbsa.php`
8. [ ] Update view: `view-rsbsa.blade.php`
9. [ ] Run: `php artisan migrate`
10. [ ] Test the form

---

## Reference: Official Form Fields (Page 2)

From DA RSBSA Enrollment Form (Revised 03-2021):

**Ownership Document Types:**
1. Certificate of Land Transfer
2. Emancipation Patent
3. Individual Certificate of Land Ownership Award (CLOA)
4. Collective CLOA
5. Co-ownership CLOA
6. Agricultural sales patent
7. Homestead patent
8. Free Patent
9. Certificate of Title or Regular Title
10. Certificate of Ancestral Domain Title
11. Certificate of Ancestral Land Title
12. Tax Declaration
13. Others (e.g. Barangay Certification)

**Farm Types:**
1. Irrigated
2. Rainfed Upland
3. Rainfed Lowland

*(NOTE: not applicable to agri-fishery)*
