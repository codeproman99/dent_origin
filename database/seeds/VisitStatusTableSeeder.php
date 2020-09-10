<?php

use Illuminate\Database\Seeder;

class VisitStatusTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if(DB::table('visit_status')->get()->count() == 0 ){
            DB::table('visit_status')->insert([
                [
                    'status_title' => 'visited',
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'status_title' => 'canceled',
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'status_title'=> 'confirmed',
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
        }
    }
}
