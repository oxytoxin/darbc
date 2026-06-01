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
        Schema::create('rsbsa_farm_parcel_commodities', function (Blueprint $table) {
            $table->id();
            $table->foreignId('rsbsa_farm_parcel_id')->constrained('rsbsa_farm_parcels')->cascadeOnDelete();

            $table->string('cropping_schedule')->nullable(); // e.g. Jan-Mar
            $table->string('commodity')->nullable();
            $table->decimal('size', 10, 4)->nullable(); // hectares
            $table->integer('no_of_heads')->nullable(); // heads / trees
            $table->string('farm_type')->nullable(); // Irrigated | Rainfed Upland | Rainfed Lowland | Urban-Peri-Urban | Not Applicable
            $table->boolean('organic_practitioner')->nullable();

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
        Schema::dropIfExists('rsbsa_farm_parcel_commodities');
    }
};
