<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use View;
use App\Repositories\PageRepositoryInterface;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    protected $page;
    public function __construct(PageRepositoryInterface $page)
    {
       // $this->middleware('auth');
        $this->page=$page;
    }
    public function getPageParams() {
        View::share('user', '');
    }

    protected function loadHeadInPage($alias = 'home')
    {
        $page = $this->page->getPageByAlias($alias);
        view()->share('title', $page->title);
        view()->share('content', $page->content);
        view()->share('keywords', $page->keywords);
        view()->share('description', $page->descrption);
    }
    
}
