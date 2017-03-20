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
        // dd('hahahahahha');
        return view('poolservice');
    }
}
