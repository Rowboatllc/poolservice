<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTablePoolowner extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('poolowners', function (Blueprint $table) {
            $table->integer('user_id')->unique();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('street');
            $table->string('city');
            $table->string('state');
            $table->integer('zipcode');
            $table->string('phone');
            $table->string('token');
            $table->string('card_last_digits');
            $table->string('pool_status');
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
        Schema::dropIfExists('poolowners');
    }
}
