<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

class PoolServiceController extends Controller {
    public function index() {
        return view('admin.poolservice');
    }
}
