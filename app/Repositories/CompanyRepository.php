<?php

namespace App\Repositories;
use App\Models\Company;

class CompanyRepository implements CompanyRepositoryInterface 
{
    protected $company;
	
    public function __construct(Company $company)
    {
        $this->company = $company;
    }

    public function getAllCompanySupportOwner($user_id){
        if (!empty($user_id)) {
            $results = DB::select('SELECT c.* FROM `companies` as c 
                LEFT JOIN orders o ON JSON_CONTAINS(c.services, o.services) 
                                    AND JSON_CONTAINS(c.zipcodes, o.zipcode)
                WHERE o.user_id = '.$user_id.'
                ');
            return $results;
        }
        return [];
    }
}