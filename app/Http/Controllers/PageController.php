<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\PageRepositoryInterface;
use App\Http\Requests\PageRequest;
use Illuminate\Support\Facades\Auth;
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
        if(isset($pages) && count($pages)>0){
            $page = $pages[0];
        }
        return view('admin.page', compact('pages','page'));
    }

    public function store(PageRequest $request){
        $alias = $request->input('alias');
        $title = $request->input('title');
        $content = $request->input('content');
        $keywords = $request->input('keywords');
        $description = $request->input('description');
        $result = $this->page->createOrUpdatePage($alias, $title, $content, $keywords, $description);
        if($result)
            return redirect()->back()
                        ->withInput($request->all())
                        ->with('success', true);

        return redirect()->back()
                        ->withInput($request->all())
                        ->with('error', true);
    }

    public function getPage(Request $request){
        $alias = $request->input('alias');
        return $this->page->getPageByAlias($alias);
    }


}
