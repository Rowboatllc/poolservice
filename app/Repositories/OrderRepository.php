<?php

namespace App\Repositories;

use App\Models\Order;

class OrderRepository {
    
    private $common;
    
    public function __construct() {
        $this->common = app('App\Common\Common');
    }
    
    public function savePoolInfo($data) {
        $obj = $this->common->getUserByToken();
        $obj = Order::where('user_id', $obj->id)->first();
        $pool = $data['is-pool'];
        $water = empty($data['watertype_weekly_pool']) ? 'chlorine' : $data['watertype_weekly_pool'];
        $obj->cleaning_object = $pool;
        $obj->water = $water;
        return $obj->save();
    }
    
}
