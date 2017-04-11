<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('profiles', function (Blueprint $table) {
            $table->integer('user_id')->unique();
            $table->string('first_name')->default('');
            $table->string('last_name')->default('');
            $table->string('fullname')->default('');            
            $table->string('address')->default('');
            $table->string('city')->default('');
            $table->string('state')->default('');
            $table->integer('zipcode')->nullable();
            $table->string('phone')->nullable();
            $table->string('avatar')->nullable();            
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
        Schema::dropIfExists('profiles');
    }
}
