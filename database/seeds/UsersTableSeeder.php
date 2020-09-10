<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            [
                'name' => 'Admin',
                'surname' => 'Admin',
                'email' => 'admin@site.com',
                'email_verified_at' => now(),
                'password' => Hash::make('administrator'),
                'phone_number' => '8581238124',
                'address' => 'way far from here n2. lidon',
                'role' => '1',
                'status' => '1',
                'active_due_date' => new DateTime('2100-01-01'),
                'business_name' => 'Admin Bussiness Name',
                'piva' => '',
                'sdi_code' => '',
                'legal_address' => '',
                'operative_address' => '',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Dentist',
                'surname' => 'dentist',
                'email' => 'dentist@site.com',
                'email_verified_at' => now(),
                'password' => Hash::make('dentist'),
                'phone_number' => '8512128124',
                'address' => 'way far from here n2. lidon',
                'role' => '2',
                'status' => '1',
                'active_due_date' => new DateTime('2100-01-01'),
                'business_name' => 'business name',
                'piva' => 'piva',
                'sdi_code' => 'sdi code',
                'legal_address' => 'legal address',
                'operative_address' => 'operative address',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Manager',
                'surname' => 'Manager',
                'email' => 'manager@site.com',
                'email_verified_at' => now(),
                'password' => Hash::make('manager'),
                'phone_number' => '8581242124',
                'address' => 'way far from here n2. lidon',
                'role' => '3',
                'status' => '1',
                'active_due_date' => new DateTime('2100-01-01'),
                'business_name' => 'bussiness name',
                'piva' => 'piva',
                'sdi_code' => 'sdi code',
                'legal_address' => 'legal address',
                'operative_address' => 'operative address',
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);
    }
}
