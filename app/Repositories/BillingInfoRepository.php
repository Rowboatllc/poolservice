<?php

namespace App\Repositories;
use App\Models\BillingInfo;
use App\Common\Common;

class BillingInfoRepository implements BillingInfoRepositoryInterface {

    protected $billing;    

    public function __construct(BillingInfo $billing)
    {
        $this->billing = $billing;
    }

    public function getBillingInfo($user_id){
        $billing = $this->billing->find($user_id);
        if($billing) {
            $billing->zipcode = $billing->zipcode[0];
        } else {
            $common = new Common;
            $billing = $common->getDefaultEloquentAttibutes($this->billing);
        }
        
        return $billing;
    }

    public function updateBillingInfo($billingInfo){
        $billing = $this->billing->find($billingInfo->user_id);

        $billingInfo->card_last_digits = substr($billingInfo->card_last_digits, -4);
        $billing->name_card = $billingInfo->name_card;
        $billing->expiration_date = $billingInfo->expiration_date;
        $billing->card_last_digits = $billingInfo->card_last_digits;
        $billing->address = $billingInfo->address;
        $billing->city = $billingInfo->city;
        $billing->state = $billingInfo->state;
        $billing->zipcode = array(intval($billingInfo->zipcode));
        $billing->token = $billingInfo->token;
        
        return $billing->save();
    }
}