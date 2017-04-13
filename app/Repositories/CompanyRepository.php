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
            $companys = DB::select('SELECT c.id, c.user_id, c.name, c.logo, AVG(COALESCE(r.point ,0)) AS point FROM companies as c 
                                     LEFT JOIN orders o ON JSON_CONTAINS(c.services, o.services) 
                                                         AND JSON_CONTAINS(c.zipcodes, o.zipcode)
                                                         AND o.status = "active"
                                    LEFT JOIN ratings r ON r.company_id = c.id
                                    WHERE o.user_id = '.$user_id.'
                                    AND c.status = "active"
                                    GROUP BY c.id
                                    ORDER BY point
                                    ');
            usort($companys, array($this, "cmp"));
            return $companys;
        }
        return [];
    }

    private function cmp($a, $b)
    {
        return strcmp($b->point, $a->point);
    }

    public function getSelectedCompany($user_id){
        if (!empty($user_id)) {
            $result = DB::select('SELECT c.id, c.user_id, c.name, c.logo, AVG(COALESCE(r.point ,0)) AS point FROM companies as c
                                    LEFT JOIN ratings r ON r.company_id = c.id
                                    WHERE c.id  IN (
                                        SELECT s.company_id FROM selecteds s
                                        LEFT JOIN orders o ON o.id = s.order_id
                                                            AND o.status = "active"
                                        WHERE o.user_id = '.$user_id.'
                                    )
                                    AND c.status = "active"
                                    GROUP BY c.id
                                    ');
        }
    }
}
