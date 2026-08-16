<?php

namespace Database\Seeders;

use App\Models\BloodGroup;
use App\Models\Donor;
use App\Models\Patient;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DemoDataSeeder extends Seeder
{
    private array $cities = [
        ['city' => 'Hyderabad', 'state' => 'Telangana'],
        ['city' => 'Bengaluru', 'state' => 'Karnataka'],
        ['city' => 'Chennai', 'state' => 'Tamil Nadu'],
        ['city' => 'Mumbai', 'state' => 'Maharashtra'],
        ['city' => 'Delhi', 'state' => 'Delhi'],
    ];

    public function run(): void
    {
        $bloodGroupIds = BloodGroup::pluck('id')->all();

        for ($i = 1; $i <= 50; $i++) {
            $location = $this->cities[array_rand($this->cities)];

            $user = User::create([
                'role' => 'Donor',
                'name' => "Donor Sample {$i}",
                'email' => "donor{$i}@example.com",
                'password' => Hash::make('password'),
                'phone' => '90000'.str_pad((string) $i, 5, '0', STR_PAD_LEFT),
                'gender' => $i % 2 === 0 ? 'Female' : 'Male',
                'dob' => now()->subYears(rand(18, 55))->toDateString(),
                'status' => 'Active',
                'email_verified_at' => now(),
            ]);

            $totalDonations = rand(0, 30);

            Donor::create([
                'user_id' => $user->id,
                'blood_group_id' => $bloodGroupIds[array_rand($bloodGroupIds)],
                'weight' => rand(50, 90),
                'medical_history' => null,
                'address' => "{$i} Sample Street",
                'city' => $location['city'],
                'state' => $location['state'],
                'pincode' => '500'.str_pad((string) $i, 3, '0', STR_PAD_LEFT),
                'availability' => 'Available',
                'total_donations' => $totalDonations,
                'current_badge' => (new Donor)->badgeForDonationCount($totalDonations),
            ]);
        }

        for ($i = 1; $i <= 50; $i++) {
            $location = $this->cities[array_rand($this->cities)];

            $user = User::create([
                'role' => 'Patient',
                'name' => "Patient Sample {$i}",
                'email' => "patient{$i}@example.com",
                'password' => Hash::make('password'),
                'phone' => '80000'.str_pad((string) $i, 5, '0', STR_PAD_LEFT),
                'gender' => $i % 2 === 0 ? 'Female' : 'Male',
                'dob' => now()->subYears(rand(18, 65))->toDateString(),
                'status' => 'Active',
                'email_verified_at' => now(),
            ]);

            Patient::create([
                'user_id' => $user->id,
                'address' => "{$i} Sample Avenue",
                'city' => $location['city'],
                'state' => $location['state'],
                'pincode' => '600'.str_pad((string) $i, 3, '0', STR_PAD_LEFT),
                'emergency_contact' => '70000'.str_pad((string) $i, 5, '0', STR_PAD_LEFT),
                'required_blood_group_id' => $bloodGroupIds[array_rand($bloodGroupIds)],
            ]);
        }
    }
}
