<?php

use Illuminate\Database\Seeder;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Zipcode;
class ZipcodeSeeder extends Seeder {

    public function run() {
        $zipcodes = Excel::load('storage/app/excels/Serviceable.zip.codes.xlsx')->get();
        foreach($zipcodes as $key => $value){
            $zipcode=new Zipcode();
            $zipcode->zipcode = $value->zipcode;
            $zipcode->city = $value->city;
            $zipcode->save();
        }
    }
}
