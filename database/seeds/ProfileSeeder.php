<?php

use Illuminate\Database\Seeder;

class ProfileSeeder extends Seeder {

    public function run() {
        factory(\App\Models\Profile::class)->create([
            'user_id' => 4,
            'first_name' => 'eric',
            'last_name' => 'mr',
            'address' => '01 nguyen hue',
            'city' => 'newyork',
            'state' => 'astate',
            'zipcode' => 77777,
            'phone' => '999999999',
            'fullname' => 'eric smith',
            'avatar' => 'upload/profile/abc.png'
        ]);
    }

}
