<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\PageRepositoryInterface;

class HomeController extends Controller
{
    /**
    * Create a new controller instance.
    *
    * @return void
    */
    public function __construct(PageRepositoryInterface $page)
    {
       // $this->middleware('auth');
       parent::__construct($page);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->loadHeadInPage('home');
        return view('home');
    }

    public function pageNotFound(){
        $this->loadHeadInPage('page_not_found');
        return view('error.page_not_found');
    }

    public function started(){
        return view('started');
    }

    public function dashboard(){
        return view('dashboard');
    }

}
