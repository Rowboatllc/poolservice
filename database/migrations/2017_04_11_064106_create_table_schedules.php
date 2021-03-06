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
            $table->integer('selected_id');  
            $table->integer('technician_id');                
            $table->datetime('date');
            $table->string('img_before')->nullable();  
            $table->string('img_after')->nullable();  
            $table->enum('status', array('opening', 'checkin', 'unable', 'billing_success', 'billing_error', 'closed'))->default('opening');
            $table->json('cleaning_steps')->nullable();     
            $table->string('comment')->nullable();  
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
