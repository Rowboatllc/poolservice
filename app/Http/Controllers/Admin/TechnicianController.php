<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

class TechnicianController extends Controller {
    public function index() {
        return view('admin.technician');
    }
}
