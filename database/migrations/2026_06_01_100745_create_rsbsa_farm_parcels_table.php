<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rsbsa_farm_parcels', function (Blueprint $table) {
            $table->id();
            $table->foreignId('rsbsa_record_id')->constrained('rsbsa_records')->cascadeOnDelete();
            $table->unsignedTinyInteger('parcel_number')->nullable();

            // Farm location
            $table->string('farm_location_barangay')->nullable();
            $table->string('farm_location_city_municipality')->nullable();
            $table->string('farm_location_province')->nullable();

            // Parcel attributes
            $table->decimal('total_parcel_area', 10, 4)->nullable();
            $table->boolean('within_ancestral_domain')->nullable();
            $table->boolean('agrarian_reform_beneficiary')->nullable();
            $table->boolean('has_land_ownership_proof')->nullable();

            // Ownership / tenure
            $table->string('ownership_type')->nullable(); // Registered Owner | Tenant | Lessee | Others
            $table->string('ownership_other_specify')->nullable();
            $table->string('land_owner_name')->nullable();

            // Identifiers and tiller
            $table->string('parcel_rsbsa_number')->nullable();
            $table->string('rotational_tiller_name')->nullable();
            $table->string('rotational_tiller_rsbsa_number')->nullable();

            $table->text('remarks')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rsbsa_farm_parcels');
    }
};
