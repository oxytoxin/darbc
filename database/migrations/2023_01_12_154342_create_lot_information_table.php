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
        Schema::create('lot_information', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->foreignId('block_id')->constrained('block_addresses');
            $table->foreignId('lot_id')->constrained('lot_addresses');
            $table->foreignId('area_id')->constrained('area_addresses');
            $table->boolean('status')->default(0);
            $table->string('buyer')->nullable();
            $table->string('date_sold')->nullable();
            $table->string('draw_date')->nullable();
            $table->string('map_url')->nullable();
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
        Schema::dropIfExists('lot_information');
    }
};
