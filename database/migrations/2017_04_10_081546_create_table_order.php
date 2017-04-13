<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableOrder extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');         
            $table->json('services');
            $table->json('zipcode');   
            $table->dateTime('time');
            $table->json('cleaning_object');
            $table->enum('water', array('salt', 'chlorine'));
            $table->float('price');
            $table->enum('status', array('active', 'inactive'))->default('active');

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
        Schema::dropIfExists('orders');
    }
}
