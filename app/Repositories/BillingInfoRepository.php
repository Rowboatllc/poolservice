<?php

namespace App\Repositories;
use App\Models\BillingInfo;

class BillingInfoRepository implements BillingInfoRepositoryInterface {

    protected $billing;    

    public function __construct(BillingInfo $billing)
    {
        $this->billing = $billing;
    }

    public function getBillingInfo($user_id){
        $billing = $this->billing->find($user_id);

        $billing->zipcode = $billing->zipcode[0];
        return $billing;
    }

    public function updateBillingInfo($user_id, $name_card, $token, $expiration_date, $card_last_digits, $address, $city, $state, $zipcode){
        $billing = $this->billing->find($user_id);

        $billing->name_card = $name_card;
        $billing->token = $token;
        $billing->expiration_date = $expiration_date;
        $billing->card_last_digits = $card_last_digits;
        $billing->address = $address;
        $billing->city = $city;
        $billing->state = $state;
        $billing->zipcode = $zipcode;

        return $billing->save();
    }
}