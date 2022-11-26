<?php

namespace Database\Factories;

use App\Models\City;
use App\Models\Cluster;
use App\Models\Province;
use App\Models\Region;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\MemberInformation>
 */
class MemberInformationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'status' => $this->faker->randomElement([1, 2, 3]),
            'darbc_id' => $this->faker->numerify('########'),
            'user_id' => User::factory(),
            'cluster_id' => $this->faker->randomElement(Cluster::pluck('id')->toArray()),
            'successor_number' => 0,
            'original_member_id' => null,
            'date_of_birth' => $this->faker->dateTimeBetween('-70 years', '-30 years'),
            'place_of_birth' => $this->faker->address,
            'gender_id' => $this->faker->randomElement([1, 2]),
            'blood_type' => $this->faker->randomElement(['A', 'B', 'AB', 'O']),
            'religion' => $this->faker->randomElement(['Roman Catholic', 'Protestant', 'Iglesia ni Cristo', 'Born Again', 'Seventh Day Adventist', 'Jehovah\'s Witness', 'Muslim', 'Buddhist', 'Hindu', 'Other']),
            'membership_status_id' => 1,
            'occupation_id' => $this->faker->randomElement([1, 2, 3]),
            'occupation_details' => null,
            'region_code' => '01',
            'province_code' => '0128',
            'city_code' => '012801',
            'barangay_code' => '012801001',
            'address_line' => $this->faker->address,
            'civil_status' => $this->faker->randomElement([1, 2, 3]),
            'children' => "[]",
            'sss_number' => $this->faker->numerify('########'),
            'philhealth_number' => $this->faker->numerify('########'),
            'tin_number' => $this->faker->numerify('########'),
            'contact_number' => $this->faker->phoneNumber,
            'application_date' => $this->faker->dateTimeBetween('-5 years', 'now'),
        ];
    }
}
