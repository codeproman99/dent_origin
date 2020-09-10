<?php

use Illuminate\Database\Seeder;

class StatusTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if(DB::table('status')->get()->count() == 0 ){
            DB::table('status')->insert([
                [
                    'status_id' => 0,
                    'status_title' => 'inactive',
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'status_id' => 1,
                    'status_title' => 'active',
                    'created_at' => now(),
                    'updated_at' => now()
                ],
            ]);
        }
    }
}
