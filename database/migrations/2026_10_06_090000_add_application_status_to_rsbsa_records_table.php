<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Track where each RSBSA application stands, so officers can monitor progress
     * straight from the Members List instead of opening every record.
     *
     * Left nullable and intentionally NOT backfilled: an existing record may already
     * be transmitted or registered with the DA, and defaulting everything to the first
     * stage would misreport those. Officers set the status once, per member.
     */
    public function up()
    {
        Schema::table('rsbsa_records', function (Blueprint $table) {
            $table->string('application_status')->nullable()->index()->after('enrollment_type');
        });
    }

    public function down()
    {
        Schema::table('rsbsa_records', function (Blueprint $table) {
            $table->dropColumn('application_status');
        });
    }
};
