<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePatientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('patients', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name_surname');
            $table->string('phone_number');
            $table->integer('dentist_id');
            $table->string('calendar_id')->unique();
            $table->datetime('first_visit_start')->nullable();
            $table->datetime('first_visit_end')->nullable();
            $table->string('visit_status')->nullable();
            $table->string('quotation_status')->nullable();
            $table->decimal('total_accepted_quotation', 8, 2)->nullable();  //total accepted quotation
            $table->decimal('total_collected', 8, 2)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('patients');
    }
}
