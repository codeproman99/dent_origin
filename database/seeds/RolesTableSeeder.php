<?php

use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         if(DB::table('roles')->get()->count() == 0 ){
            DB::table('roles')->insert([
                [
                    'role_name'   => 'admin',
                    'description' => 'admin',
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'role_name'   => 'studio',
                    'description' => 'studio',
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'role_name'   => 'manager',
                    'description' => 'manager',
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
        }
    }
}
