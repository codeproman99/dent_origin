<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([UsersTableSeeder::class]);
        $this->call([QuotationStatusTableSeeder::class]);
        $this->call([VisitStatusTableSeeder::class]);
        $this->call([StatusTableSeeder::class]);
        $this->call([RolesTableSeeder::class]);
        $this->call([PatientsTableSeeder::class]);
        $this->call([SchedulesTableSeeder::class]);
    }
}
