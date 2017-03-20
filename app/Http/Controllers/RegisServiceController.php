<?php

namespace App\Http\Controllers;

class RegisServiceController extends Controller
{
    public function __construct()
    {
        // $this->middleware('auth');
    }
    public function index()
    {
        return view('poolservice');
    }
}
