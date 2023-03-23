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
        Schema::create('cash_advances', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('status')->default(1);
            $table->foreignId('user_id')->constrained();
            $table->text('purpose')->nullable();
            $table->text('illness')->nullable();
            $table->string('contact_number')->nullable();
            $table->integer('account_amount')->nullable();
            $table->integer('requested_amount')->nullable();
            $table->integer('approved_amount')->nullable();
            $table->date('date_received')->nullable();
            $table->date('date_approved')->nullable();
            $table->json('other_details');
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
        Schema::dropIfExists('cash_advances');
    }
};
