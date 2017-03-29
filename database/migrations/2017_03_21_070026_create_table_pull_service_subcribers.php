<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTablePullServiceSubcribers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pool_subscribers', function (Blueprint $table) {
            $table->integer('zipcode')->unsigned();
            $table->string('service_type');
            $table->integer('user_id')->unique()->references('id')->on('users')->onDelete('cascade');
            
            $table->string('cleaning_object');
            $table->enum('water', array('salt', 'chlorine'))->nullable();
            $table->float('price')->default(0);
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
        Schema::dropIfExists('articles');
    }
}
