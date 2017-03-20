<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\PageRepositoryInterface;

class ContactController extends Controller
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
        $this->loadHeadInPage('contact');
        return view('contact');
    }

}
