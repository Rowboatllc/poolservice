<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

class TechnicanController extends Controller {
    public function index() {
        return view('admin.technican');
    }
}
