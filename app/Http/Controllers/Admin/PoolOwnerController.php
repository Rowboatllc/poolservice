<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

class PoolOwnerController extends Controller {
    public function index() {
        return view('admin.poolowner');
    }
}
