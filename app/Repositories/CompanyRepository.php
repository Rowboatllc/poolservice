<?php

namespace App\Repositories;
use App\Models\Company;
use Illuminate\Support\Facades\DB;

class CompanyRepository implements CompanyRepositoryInterface 
{
    protected $company;
	
    public function __construct(Company $company)
    {
        $this->company = $company;
    }

    public function getAllCompanySupportOwner($user_id){
        if (!empty($user_id)) {
            $companys = DB::select('SELECT c.*, AVG(COALESCE(r.point ,0)) AS point FROM companies as c 
                                     LEFT JOIN orders o ON JSON_CONTAINS(c.services, o.services) 
                                                         AND JSON_CONTAINS(c.zipcodes, o.zipcode)
                                    LEFT JOIN ratings r ON r.company_id = c.id
                                    WHERE o.user_id = '.$user_id.'
                                    AND c.status = "inactive"
                                    GROUP BY c.id
                                    ORDER BY point
                                    ');
            usort($companys, array($this, "cmp"));
            return $companys;
        }
        return [];
    }

    function cmp($a, $b)
    {
        return strcmp($b->point, $a->point);
    }
}
