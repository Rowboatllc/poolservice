<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\PageRepositoryInterface;
use App\Http\Requests\PageRequest;
use Illuminate\Support\Facades\Auth;
use App\Repositories\AclRepository;
class PageController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    protected $page;
    protected $acl;
    public function __construct(PageRepositoryInterface $page, AclRepository $acl)
    {
        $this->page=$page;
        $this->acl=$acl;
        
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->loadHeadInPage('contact');
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

    public function testACL(){
        $group_name = 'Test';
        $group_description = 'Test description';
        $this->acl->createGroup($group_name,$group_description);
    }
    
}
