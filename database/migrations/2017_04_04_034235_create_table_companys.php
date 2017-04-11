<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableCompanys extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('companys', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->json('services');
            $table->json('zipcode');
            $table->string('address');
            $table->string('logo');
            $table->enum('status', array('pending', 'unclaimed', 'active', 'inactive'))->default('pending');
            $table->string('token');
            $table->string('website');
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
        Schema::dropIfExists('companys');
    }
}
