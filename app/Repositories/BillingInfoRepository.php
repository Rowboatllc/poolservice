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

    public function updateBillingInfo($user_id, array $array){
        $billing = $this->billing->find($user_id);

        $billing->name_card = $array['name_card'];
        $billing->expiration_date = $array['expiration_date'];
        $billing->card_last_digits = substr($array['card_last_digits'], -4);
        $billing->address = $array['address'];
        $billing->city = $array['city'];
        $billing->state = $array['state'];
        $billing->zipcode = array(intval($array['zipcode']));
        $billing->token = $array['token'];
        
        return $billing->save();
    }
}