<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\PageRepositoryInterface;

class PageController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(PageRepositoryInterface $page)
    {
       // $this->middleware('auth');
        $this->page=$page;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('page');
    }

}
