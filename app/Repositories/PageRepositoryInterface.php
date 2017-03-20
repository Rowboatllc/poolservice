<?php

namespace App\Repositories;

interface PageRepositoryInterface
{
	public function getPageByAlias($alias);
}