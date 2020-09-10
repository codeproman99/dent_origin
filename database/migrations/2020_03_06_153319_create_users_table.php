<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('surname');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('phone_number')->nullable();
            $table->string('address')->nullable();
            $table->string('password');
            $table->Integer('role')->default(1);
            $table->Integer('status')->default(1);
            $table->dateTime('active_due_date')->nullable();
            $table->string('business_name');
            $table->string('piva')->nullable();
            $table->string('sdi_code')->nullable();
            $table->string('legal_address')->nullable();
            $table->string('operative_address')->nullable();
            $table->boolean('self_manager')->default(false);
            $table->integer('assigned_manager')->nullable();
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
