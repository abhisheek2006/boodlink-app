<?php

namespace Database\Seeders;

use App\Models\BloodGroup;
use App\Models\BloodStock;
use Illuminate\Database\Seeder;

class BloodGroupSeeder extends Seeder
{
    public function run(): void
    {
        $groups = ['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-'];

        foreach ($groups as $name) {
            $bloodGroup = BloodGroup::firstOrCreate(
                ['name' => $name],
                ['description' => "Blood group {$name}", 'status' => 'Active']
            );

            BloodStock::firstOrCreate(
                ['blood_group_id' => $bloodGroup->id],
                ['units' => rand(10, 80), 'status' => 'Sufficient']
            );
        }
    }
}
