<?php

namespace App\Repositories;
use App\Models\Page;

class PageRepository implements PageRepositoryInterface 
{
    protected $page;
	
    public function __construct(Page $page)
    {
            $this->page = $page;
    }
	
    public function getPageByAlias($alias){
        $page = $this->page->where('alias',$alias)->first();
        if(!isset($page)){
            $page = new Page();
            $page->title = 'PoolService';
            $page->content = '';
            $page->metadata_keyword = '';
            $page->metadata_desc = '';
        }
        return $page;
    }

    public function getAllPage(){
        return $this->page->get();
    }

}