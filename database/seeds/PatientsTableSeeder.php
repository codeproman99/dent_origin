<?php

use Illuminate\Database\Seeder;

class PatientsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('patients')->insert([
            'name_surname' => 'Patient1 patient',
            'phone_number' => '8581238124',
            'dentist_id' => 1,
            'calendar_id' => '2313124123',
            'first_visit_start' => new DateTime('2020-03-10'),
            'first_visit_end' => new DateTime('2020-03-11'),
            'visit_status' => 1,
            'quotation_status' => 2,
            'total_accepted_quotation' => 1304,
            'total_collected' => 221,
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}
