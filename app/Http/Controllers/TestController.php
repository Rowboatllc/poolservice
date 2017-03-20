<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TestController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    private $repo;
    public function __construct()
    {
       // $this->middleware('auth');
        //$this->getPageParams();
        $this->repo = app('App\Repositories\OptionRepository');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('test');
    }
    
    public function abc()
    {
        return $this->repo->getOption('rkris');
    }
    
    public function saveAbc(Request $request)
    {
        return $this->repo->getOption('rkris');
    }
    
    private function _getParams($data) {
        
    }
    
}
