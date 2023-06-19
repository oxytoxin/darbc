<?php

use App\Models\ElderlyIncentiveType;
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
        Schema::create('elderly_incentive_types', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->unsignedInteger('minimum_age');
            $table->unsignedBigInteger('amount');
            $table->timestamps();
        });

        ElderlyIncentiveType::create([
            'name' => '80 Years Old Incentive',
            'minimum_age' => 80,
            'amount' => 80000,
        ]);

        ElderlyIncentiveType::create([
            'name' => '90 Years Old Incentive',
            'minimum_age' => 90,
            'amount' => 90000,
        ]);

        ElderlyIncentiveType::create([
            'name' => '100 Years Old Incentive',
            'minimum_age' => 100,
            'amount' => 100000,
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('elderly_incentive_types');
    }
};
