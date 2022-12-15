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
        Schema::create('dividends', function (Blueprint $table) {
            $table->id();
            $table->foreignId('release_id')->constrained();
            $table->foreignId('user_id')->constrained();
            $table->integer('gross_amount');
            $table->integer('deductions_amount')->default(0);
            $table->tinyInteger('status')->default(1);
            $table->boolean('voided')->default(false);
            $table->boolean('claimed')->default(false);
            $table->json('particulars');
            $table->json('restriction_entries');
            $table->foreignId('released_by')->nullable()->constrained('users');
            $table->dateTime('released_at')->nullable();
            $table->string('gift_certificate_control_number')->nullable();
            $table->string('claimed_by')->nullable();
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
        Schema::dropIfExists('dividends');
    }
};
