<?php

use App\Models\Payslip;
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
        Schema::create('payslip_entries', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Payslip::class)->constrained()->cascadeOnDelete();
            $table->string('member_name');
            $table->json('content')->default(DB::raw("'(JSON_ARRAY())'"));
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
        Schema::dropIfExists('payslip_entries');
    }
};
