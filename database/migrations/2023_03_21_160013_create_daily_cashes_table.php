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
        Schema::create('daily_cashes', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('status')->default(1);
            $table->foreignId('release_id');
            $table->string('lane');
            $table->foreignId('cashier_id')->constrained('users');
            $table->tinyInteger('type');
            $table->json('denominations');
            $table->integer('amount');
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
        Schema::dropIfExists('daily_cashes');
    }
};
