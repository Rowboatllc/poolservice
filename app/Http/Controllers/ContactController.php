<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\PageRepositoryInterface;
use App\Repositories\OptionRepositoryInterface;

class ContactController extends Controller
{
    /**
    * Create a new controller instance.
    *
    * @return void
    */
    protected $option;

    public function __construct(PageRepositoryInterface $page, OptionRepositoryInterface $option)
    {
       parent::__construct($page);
       $this->option=$option;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->loadHeadInPage('contact');
        $block_contact_left = $this->option->getOption(config('app.key_block_contact_left'));
        // dd($block_contact_left);
        return view('contact', compact('block_contact_left'));
    }

}
