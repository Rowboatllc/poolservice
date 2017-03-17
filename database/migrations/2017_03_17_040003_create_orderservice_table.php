<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderserviceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_service', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('account_service')->unsigned();
            $table->integer('object_owner')->unsigned();
            $table->integer('zip')->unsigned();
            $table->string('service_type');
            $table->dateTime('time');
            $table->enum('cleaning_object', array('pool', 'spa'));
            $table->enum('water', array('salt', 'chlorine'))->nullable();
            $table->float('price');
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
        Schema::dropIfExists('orderservice');
    }
}
