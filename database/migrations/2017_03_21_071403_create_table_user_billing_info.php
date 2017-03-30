<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableUserBillingInfo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('billing_infos', function (Blueprint $table) {
            $table->integer('user_id')->unique()->references('id')->on('users')->onDelete('cascade');
            
            $table->string('billing_address');
            $table->string('billing_city')->nullable();
            $table->string('billing_state')->nullable();
            $table->integer('zipcode')->unsigned()->nullable();
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
