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
        Schema::create('free_lots', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->foreignId('cluster_id')->nullable()->constrained();
            $table->string('reference_name')->nullable();
            $table->string('block')->nullable();
            $table->string('lot')->nullable();
            $table->string('area')->nullable();
            $table->smallInteger('status')->default(1);
            $table->string('buyer')->nullable();
            $table->date('sold_at')->nullable();
            $table->date('draw_date')->nullable();
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
        Schema::dropIfExists('free_lots');
    }
};
