<?php

use Illuminate\Database\Seeder;

class QuotationStatusTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if(DB::table('quotation_status')->get()->count() == 0) {
            DB::table('quotation_status')->insert([
                [
                    'status_title' => 'given',
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'status_title' => 'accepted',
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]);
        } else {
            echo "Table is not empty. Therefore NOT";
        }

    }
}
