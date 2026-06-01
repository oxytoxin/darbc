<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Add fields introduced by the RSBSA Enrollment Form (revised 01-2024).
     * All columns are nullable so existing records are unaffected.
     */
    public function up()
    {
        Schema::table('rsbsa_records', function (Blueprint $table) {
            // Transaction code (PhilID PCN vs No-PhilID TRN)
            $table->boolean('has_philid')->nullable()->after('reference_number');
            $table->string('philsys_card_number')->nullable()->after('has_philid');
            $table->string('transaction_reference_number')->nullable()->after('philsys_card_number');

            // Provincial address (answered only when permanent address is in NCR)
            $table->text('provincial_house_lot_bldg_purok')->nullable()->after('region');
            $table->string('provincial_street_sitio_subdv')->nullable()->after('provincial_house_lot_bldg_purok');
            $table->string('provincial_barangay')->nullable()->after('provincial_street_sitio_subdv');
            $table->string('provincial_city_municipality')->nullable()->after('provincial_barangay');
            $table->string('provincial_province')->nullable()->after('provincial_city_municipality');
            $table->string('provincial_region')->nullable()->after('provincial_province');

            // Mobile number ownership
            $table->boolean('owns_mobile_number')->nullable()->after('contact_number');
            $table->string('mobile_owner_name')->nullable()->after('owns_mobile_number');
            $table->string('mobile_owner_relationship')->nullable()->after('mobile_owner_name');

            // FCA/IA/Organization membership allows up to three names
            $table->string('farmers_association_name_2')->nullable()->after('farmers_association_name');
            $table->string('farmers_association_name_3')->nullable()->after('farmers_association_name_2');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('rsbsa_records', function (Blueprint $table) {
            $table->dropColumn([
                'has_philid',
                'philsys_card_number',
                'transaction_reference_number',
                'provincial_house_lot_bldg_purok',
                'provincial_street_sitio_subdv',
                'provincial_barangay',
                'provincial_city_municipality',
                'provincial_province',
                'provincial_region',
                'owns_mobile_number',
                'mobile_owner_name',
                'mobile_owner_relationship',
                'farmers_association_name_2',
                'farmers_association_name_3',
            ]);
        });
    }
};
