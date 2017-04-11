<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableBillingInfo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('billing_info', function (Blueprint $table) {
            $table->integer('user_id')->unique();       
            $table->string('name_card');
            $table->string('number_card');   
            $table->string('token');
            $table->string('expiration_date');
            $table->string('card_last_digits');
            $table->string('address');
            $table->string('city');
            $table->string('state');      
            $table->string('zipcode');                              
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
        Schema::dropIfExists('billing_info');
    }
}
