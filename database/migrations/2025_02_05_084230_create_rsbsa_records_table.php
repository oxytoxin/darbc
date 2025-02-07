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
        Schema::create('rsbsa_records', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('darbc_id');
            $table->foreignId('member_information_id')->constrained();
            $table->foreignId('user_id')->constrained();

            $table->enum('enrollment_type', ['New', 'Updating']);
            $table->string('reference_number')->nullable();
            $table->string('region_code')->nullable();
            $table->string('province_code')->nullable();
            $table->string('city_municipality_code')->nullable();
            $table->string('barangay_code')->nullable();
            //PERSONAL INFORMATION

            $table->string('surname');
            $table->string('middle_name')->nullable();
            $table->string('first_name');
            $table->string('extension_name')->nullable();
            $table->string('sex')->nullable();
            $table->text('house_lot_bldg_purok')->nullable(); 
            $table->string('street_sitio_subdv')->nullable(); 
            $table->string('barangay')->nullable(); 
            $table->string('city_municipality')->nullable(); 
            $table->string('province')->nullable(); 
            $table->string('region')->nullable(); 
            $table->string('contact_number')->nullable();
            $table->string('landline_number')->nullable();
            $table->date('date_of_birth')->nullable();
            $table->string('place_of_birth_municipality')->nullable();
            $table->string('place_of_birth_province')->nullable();
            $table->string('place_of_birth_country')->nullable();
            $table->string('religion')->nullable();
            $table->string('civil_status')->nullable();
            $table->string('name_of_spouse')->nullable();
            $table->string('mother_maiden_name')->nullable();
            $table->boolean('household_head')->default(false);
            $table->string('name_of_household_head')->nullable();
            $table->string('relationship_with_household_head')->nullable();
            $table->integer('no_of_living_household_members')->default(0);
            $table->integer('no_of_male')->default(0);
            $table->integer('no_of_female')->default(0);
            $table->string('highest_formal_education')->nullable();
            $table->boolean('is_pwd')->default(false);
            $table->boolean('is_4ps_beneficiary')->default(false);
            $table->boolean('is_indigenous_group_member')->default(false);
            $table->string('indigenous_group_name')->nullable();
            $table->boolean('has_government_id')->default(false); 
            $table->string('id_type')->nullable();
            $table->string('id_number')->nullable(); 
            $table->boolean('is_farmers_association_member')->default(false);
            $table->string('farmers_association_name')->nullable();
            $table->string('emergency_contact_name')->nullable();
            $table->string('emergency_contact_number')->nullable();
            
            
            // Farm Profile
            $table->enum('main_livelihood', ['Farmer', 'Farmworker/Laborer', 'Fisherfolk', 'Agri Youth']);
            $table->boolean('farming_rice')->default(false);
            $table->boolean('farming_corn')->default(false);
            $table->boolean('other_crops')->default(false);
            $table->string('farming_other_crops')->nullable(); 
            $table->boolean('livestock')->default(false);
            $table->string('farming_livestock')->nullable();  
            $table->boolean('poultry')->default(false);
            $table->string('farming_poultry')->nullable();    

            // For Farmworkers
            $table->boolean('work_land_preparation')->default(false);
            $table->boolean('work_planting_transplanting')->default(false);
            $table->boolean('work_cultivation')->default(false);
            $table->boolean('work_harvesting')->default(false);
            $table->boolean('work_others')->default(false);
            $table->string('work_others_specify')->nullable(); 

            // For Fisherfolk
            $table->boolean('fishing_fish_capture')->default(false);
            $table->boolean('fishing_aquaculture')->default(false);
            $table->boolean('fishing_gleaning')->default(false);
            $table->boolean('fishing_fish_processing')->default(false);
            $table->boolean('fishing_fish_vending')->default(false);
            $table->boolean('work_others')->default(false);
            $table->string('fishing_others')->nullable(); 
            $table->string('fishing_others_specify')->nullable();

            // For Agri Youth
            $table->boolean('youth_farming_household')->default(false);
            $table->boolean('youth_agri_course')->default(false);
            $table->boolean('youth_nonformal_agri_course')->default(false);
            $table->boolean('youth_agri_program')->default(false);
            $table->boolean('youth_others')->default(false);
            $table->string('work_others_specify')->nullable(); 

            // Gross Annual Income
            $table->decimal('gross_annual_income_farming', 10, 2)->nullable(); 
            $table->decimal('gross_annual_income_nonfarming', 10, 2)->nullable(); 

            $table->timestamps();



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
        Schema::dropIfExists('rsbsa_records');
    }
};
