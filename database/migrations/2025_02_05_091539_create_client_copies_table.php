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
        Schema::create('client_copies', function (Blueprint $table) {
            $table->id();

         
            $table->foreignId('rsbsa_record_id')->constrained()->cascadeOnDelete();

   
            $table->string('reference_number')->unique();
            $table->string('surname');
            $table->string('first_name');
            $table->string('middle_name')->nullable();
            $table->string('extension_name')->nullable();
            $table->timestamp('date_of_submission')->useCurrent();

        
            $table->integer('total_farm_parcels')->nullable();
            $table->json('farm_locations')->nullable();
           
            $table->string('verified_by')->nullable(); 
            $table->string('verified_by_position')->nullable(); 

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
        Schema::dropIfExists('client_copies');
    }
};
