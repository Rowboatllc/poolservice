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
        return $this->page->where('alias',$alias)->first();
    }

}
