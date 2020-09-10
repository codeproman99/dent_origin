<?php

use Illuminate\Database\Seeder;

class SchedulesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('schedules')->insert([
            'dentist_id' => 2,
            'calendar_id' => '242523242',
            'title' => 'Admin admin',
            'start' => new DateTime('2020-03-09 12:12'),
            'end' => new DateTime('2020-03-09 15:56'),
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}
