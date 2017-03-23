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
        $this->page=$page;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pages = $this->page->getAllPage();
        return view('admin.page', compact('pages'));
    }

    public function store(Request $request){
        $name = $request->input('name');
        dd($name);
    }

}
