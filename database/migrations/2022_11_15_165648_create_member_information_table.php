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
        Schema::create('member_information', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('status')->default(1);
            $table->string('darbc_id');
            $table->foreignId('user_id')->constrained();
            $table->foreignId('cluster_id')->constrained();
            $table->mediumInteger('succession_number')->default(0);
            $table->string('lineage_identifier');
            $table->foreignId('original_member_id')->nullable()->constrained('users');
            $table->date('date_of_birth');
            $table->text('place_of_birth')->nullable();
            $table->foreignId('gender_id')->constrained();
            $table->string('blood_type')->nullable();
            $table->string('religion')->nullable();
            $table->foreignId('membership_status_id')->constrained();
            $table->foreignId('occupation_id')->constrained();
            $table->text('occupation_details')->nullable();
            $table->string('province_code')->nullable()->index();
            $table->string('region_code')->nullable()->index();
            $table->string('city_code')->nullable()->index();
            $table->string('barangay_code')->nullable()->index();
            $table->text('address_line')->nullable();
            $table->tinyInteger('civil_status')->default(1);
            $table->json('children');
            $table->string('sss_number')->nullable();
            $table->string('philhealth_number')->nullable();
            $table->string('tin_number')->nullable();
            $table->string('contact_number')->nullable();
            $table->date('application_date');
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
        Schema::dropIfExists('member_information');
    }
};
