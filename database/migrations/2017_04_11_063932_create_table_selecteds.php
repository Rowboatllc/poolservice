<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableSelecteds extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('selecteds', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('order_id');         
            $table->integer('company_id');
            $table->enum('status', array('pending', 'active', 'inactive', 'denied', 'pause', 'assigned'))->default('pending');
            $table->integer('dayofweek')->nullable();
            $table->integer('technician_id')->nullable();          
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
        Schema::dropIfExists('selecteds');
    }
}
