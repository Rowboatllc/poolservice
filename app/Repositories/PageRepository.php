<?php

namespace App\Repositories;
use App\Models\Page;

class PageRepository implements PageRepositoryInterface 
{
    protected $page;
    private $space = ':,:';
	
    public function __construct(Page $page)
    {
            $this->page = $page;
    }
	
    public function getPageByAlias($alias){
        $page = $this->page->where('alias',$alias)->first();
        if(!isset($page)){
            $page = new Page();
            $page->title = '';
            $page->content = '';
            $page->keywords = '';
            $page->description = '';
        }else{
            $this->converKeyword($page);
        }
        return $page;
    }

    public function getAllPage(){
        $pages = $this->page->get();
        foreach($pages as $page){
            $this->converKeyword($page);
        }
        return $pages;
    }

    public function createOrUpdatePage($alias, $title, $content, $keywords, $description){
        $keywords = implode($this->space,$keywords);
        $page = $this->page->where('alias',$alias)->first();
        if (!isset($page)) {
            $page = new Page();    
        }
        $page->title = $title;
        $page->content = $content;
        $page->keywords = $keywords;
        $page->description = $description;
        return $page->save();
    }

    private function converKeyword(Page &$page){
        $page->keywords = explode($this->space,$page->keywords);
    }


}