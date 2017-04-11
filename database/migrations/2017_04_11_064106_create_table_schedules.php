<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableSchedules extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('schedules', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('technican_id');    
            $table->integer('order_id');         
            $table->integer('company_id');                          
            $table->dateTime('date');
            $table->string('img_before');   
            $table->string('img_after');  
            $table->enum('status', array('pending', 'active', 'inactive'))->default('pending');
            $table->string('cost');   
            $table->string('cleaning_steps');   
            $table->string('comment');
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
        Schema::dropIfExists('schedules');
    }
}
