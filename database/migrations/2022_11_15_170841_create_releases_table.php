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
        Schema::create('releases', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->unsignedBigInteger('total_amount');
            $table->string('gift_certificate_prefix')->nullable();
            $table->decimal('gift_certificate_amount')->default(0);
            $table->json('particulars')->default(DB::raw('(JSON_ARRAY())'));
            $table->boolean('disbursed')->default(false);
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
        Schema::dropIfExists('releases');
    }
};
