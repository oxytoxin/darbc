<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\RsbsaRecord;
use App\Models\MemberInformation;

/**
 * Fills one existing RSBSA record with complete, realistic demo data
 * (including the new 01-2024 form fields and farm parcels) so the
 * View / Download PDF features can be tested without manual registration.
 *
 * Idempotent: re-running resets the same record's demo fields and parcels.
 *
 * Run: php artisan db:seed --class=RsbsaDemoSeeder
 */
class RsbsaDemoSeeder extends Seeder
{
    public function run(): void
    {
        $record = RsbsaRecord::where('darbc_id', 7520)->first()
            ?? RsbsaRecord::whereHas(
                'memberInformation',
                fn ($q) => $q->where('status', MemberInformation::STATUS_ACTIVE)
            )->whereNotNull('surname')->first();

        if (! $record) {
            $this->command->warn('RsbsaDemoSeeder: no RSBSA record found to seed.');
            return;
        }

        // Keep existing real name/address; fill anything missing + all new fields.
        $record->update([
            'enrollment_type'             => 'New',

            // Transaction code (PhilSys)
            'has_philid'                  => true,
            'philsys_card_number'         => '1234567890123456',
            'transaction_reference_number'=> null,

            // Core personal (only fill if blank)
            'sex'                         => $record->sex ?: 'Male',
            'date_of_birth'               => $record->date_of_birth ?: '1975-06-15',
            'contact_number'              => $record->contact_number ?: '09171234567',
            'civil_status'                => $record->civil_status ?: MemberInformation::CS_MARRIED,
            'name_of_spouse'              => $record->name_of_spouse ?: 'Maria Santos Zerrudo',
            'mother_maiden_name'          => $record->mother_maiden_name ?: 'Cruz',
            'religion'                    => $record->religion ?: 'Catholic',
            'highest_formal_education'    => $record->highest_formal_education ?: 'College',
            'place_of_birth_municipality' => $record->place_of_birth_municipality ?: 'Panabo City',
            'place_of_birth_province'     => $record->place_of_birth_province ?: 'Davao del Norte',

            // Mobile ownership (new)
            'owns_mobile_number'          => true,
            'mobile_owner_name'           => null,
            'mobile_owner_relationship'   => null,

            // Status flags
            'is_pwd'                      => false,
            'is_4ps_beneficiary'          => true,
            'is_indigenous_group_member'  => false,
            'has_government_id'           => true,
            'id_type'                     => 'PhilSys ID',
            'id_number'                   => '1234-5678-9012',

            // Farmers association (new extra slots)
            'is_farmers_association_member' => true,
            'farmers_association_name'      => 'DARBC Farmers Association',
            'farmers_association_name_2'    => 'Panabo Irrigators Association',
            'farmers_association_name_3'    => null,

            // Livelihood + income
            'main_livelihood'             => ['Farmer'],
            'gross_annual_income_farming' => 120000,
            'gross_annual_income_nonfarming' => 30000,
        ]);

        $record->syncFarmParcels([
            [
                'farm_location_barangay'          => 'San Vicente',
                'farm_location_city_municipality' => 'Panabo City',
                'farm_location_province'          => 'Davao del Norte',
                'total_parcel_area'               => 2.5000,
                'within_ancestral_domain'         => false,
                'agrarian_reform_beneficiary'     => true,
                'has_land_ownership_proof'        => true,
                'ownership_type'                  => 'Registered Owner',
                'land_owner_name'                 => 'Wilfredo Zerrudo',
                'parcel_rsbsa_number'             => null,
                'remarks'                         => 'Primary rice parcel',
                'commodities' => [
                    ['cropping_schedule' => 'Jan-Apr', 'commodity' => 'Rice', 'size' => 1.5000, 'farm_type' => 'Irrigated', 'organic_practitioner' => false],
                    ['cropping_schedule' => 'May-Aug', 'commodity' => 'Corn', 'size' => 1.0000, 'farm_type' => 'Rainfed Upland', 'organic_practitioner' => true],
                ],
            ],
            [
                'farm_location_barangay'          => 'Kasilak',
                'farm_location_city_municipality' => 'Panabo City',
                'farm_location_province'          => 'Davao del Norte',
                'total_parcel_area'               => 1.0000,
                'within_ancestral_domain'         => false,
                'agrarian_reform_beneficiary'     => false,
                'has_land_ownership_proof'        => true,
                'ownership_type'                  => 'Tenant',
                'land_owner_name'                 => 'Pedro Reyes',
                'remarks'                         => 'Leased banana parcel',
                'commodities' => [
                    ['cropping_schedule' => 'Year-round', 'commodity' => 'Banana', 'size' => 1.0000, 'farm_type' => 'Rainfed Lowland', 'organic_practitioner' => false],
                ],
            ],
        ]);

        $this->command->info("RsbsaDemoSeeder: seeded record id={$record->id} darbc={$record->darbc_id} ({$record->surname}, {$record->first_name}) with " . $record->farmParcels()->count() . ' parcels.');
    }
}
