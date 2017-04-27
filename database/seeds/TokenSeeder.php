<?php

use Illuminate\Database\Seeder;

class TokenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // set new user admin
        $obj = new App\Models\Tokens;
        $obj->create([
            'user_id' => 3,
            'api_token' => 'EBZTD1ykD5k8U7GSfZDxlbu3smwlow3IEtBplB8n302cN2PuH0dcE6ooGEGS',
            'client' => '',
            'expires_on' => '2017-06-30 00:00:00',            
        ]);
		
    }
}