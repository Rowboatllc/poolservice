<?php

namespace App\Repositories;
use App\Models\Company;
use App\Models\Order;
use App\Models\Selected;
use App\Models\Rating;

use Illuminate\Support\Facades\DB;

class CompanyRepository implements CompanyRepositoryInterface 
{
    protected $company;
    protected $order;
    protected $selected;
    protected $rating;    

    public function __construct(Company $company, Order $order, Selected $selected, Rating $rating)
    {
        $this->company = $company;
        $this->order = $order;
        $this->selected = $selected;
        $this->rating = $rating;
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
            $companys = DB::select('SELECT c.id, c.user_id, c.name, c.logo, AVG(COALESCE(r.point ,0)) AS point FROM companies as c
                                    LEFT JOIN ratings r ON r.company_id = c.id
                                    WHERE c.id  IN (
                                        SELECT s.company_id FROM selecteds s
                                        LEFT JOIN orders o ON o.id = s.order_id
                                                            AND o.status = "active"
                                        WHERE o.user_id = '.$user_id.'
                                        AND s.status = "pending" OR s.status = "active"
                                    )
                                    AND c.status = "active"
                                    GROUP BY c.id
                                    ');
            return $companys;
        }
        return [];
    }

    public function removeAllSelectCompany($user_id){
        return DB::statement('UPDATE `selecteds` SET `status`= "inactive"
                                WHERE `order_id` IN (
                                    SELECT o.id FROM orders o
                                    WHERE o.user_id = '.$user_id.'
                                )
                            ');
    }
    public function selectCompany($user_id, $company_id, $status = 'pending'){
        $order = $this->order->where([
            ['user_id',$user_id],
            ['status','active']
        ])->first();
        if(!isset($order)){
            return false;
        }
        $this->removeAllSelectCompany($user_id);
        $selected = new Selected();
        $selected->order_id = $order->id;
        $selected->company_id = $company_id;
        $selected->status = $status;
        
        return $selected->save();
    }
    public function activeSelectCompany($id, $status = 'active'){
        return DB::update('UPDATE `selecteds` SET `status`= '.$status.' WHERE id ='.$id.'');
    }

    public function getRatingCompany($user_id, $company_id){
        $rating = $this->rating->where([
            ['user_id', $user_id],
            ['company_id', $company_id]
        ])
        ->first();
        if(isset($rating)){
            return $rating->point;
        }
        return 0;
    }

    public function saveRatingCompany($user_id, $company_id, $point){
        $rating = $this->rating->where([
            ['user_id', $user_id],
            ['company_id', $company_id]
        ])
        ->first();
        if(isset($rating)){
            $rating->point = $point;
        }else{
            $rating = new Rating();
            $rating->user_id = $user_id;
            $rating->company_id = $company_id;
            $rating->point = $point;
        }
        return $rating->save();
    }
}
