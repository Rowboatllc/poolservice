<?php

namespace App\Repositories;

use App\Models\Order;

class OrderRepository {

    private $common;

    public function __construct() {
        $this->common = app('App\Common\Common');
    }

    public function getPoolInfo($id) {
        return Order::where('poolowner_id', $id)->select('water','cleaning_object')->first();
    }
    
    public function savePoolInfo($id, $data) {
        $obj = Order::where('poolowner_id', $id)->first();
        $pool = $data['is-pool'];
        $water = empty($data['watertype_weekly_pool']) ? 'chlorine' : $data['watertype_weekly_pool'];
        $obj->cleaning_object = $pool;
        $obj->water = $water;
        return $obj->save();
    }

}
