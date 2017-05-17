<?php

namespace App\Repositories;

use App\Models\Company;
use App\Models\Order;
use App\Models\Selected;
use App\Models\Rating;
use App\Models\User;
use Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Mail;

class CompanyRepository implements CompanyRepositoryInterface {

    protected $company;
    protected $order;
    protected $selected;
    protected $rating;
    protected $user;
    private $common;
    private $schedule;

    public function __construct(Company $company, Order $order, Selected $selected, Rating $rating) {
        $this->company = $company;
        $this->order = $order;
        $this->selected = $selected;
        $this->rating = $rating;
        $this->user = app('App\Repositories\UserRepository');
        $this->common = app('App\Common\Common');
        $this->notification = app('App\Repositories\NotificationRepository');
    }

    public function getAllCompanySupportOwner($user_id, $zipcode) {
        if (!empty($user_id)) {
            $companys = DB::select('SELECT c.id, c.user_id, c.name, c.logo, AVG(COALESCE(r.point ,0)) AS point,
                                            COUNT(DISTINCT r.user_id) as count, MAX(s.date) as date_available FROM companies as c 
                                    LEFT JOIN orders o ON JSON_CONTAINS(c.services, o.services) 
                                                        AND JSON_CONTAINS(c.zipcodes, o.zipcode)
                                                        AND o.status = "active"
                                                        
                                    LEFT JOIN ratings r ON r.company_id = c.id

                                    LEFT JOIN schedules s ON s.company_id = c.id 
                                                            AND s.status NOT IN ("closed")
                                                            AND s.order_id IN (
                                                                SELECT id FROM(
                                                                        SELECT o1.id FROM orders as o1
                                                                        WHERE JSON_CONTAINS(o1.zipcode, "[' . $zipcode . ']")
                                                                ) as arbitraryTableName
                                                            )
                                                            
                                    WHERE o.poolowner_id = ' . $user_id . '
                                    AND c.status = "active-verified"
                                    GROUP BY c.id
                                    ');
            usort($companys, array($this, "cmp"));
            return $companys;
        }
        return [];
    }

    private function cmp($a, $b) {
        return strcmp($b->point, $a->point);
    }

    public function getCompanyById($company_id) {
        $company = $this->company->find($company_id);
        $company->email = $this->user->getUserByUserId($company->user_id)->email;
        return $company;
    }

    public function getCompanyProfile($user_id) {
        if (!empty($user_id)) {
            $companys = DB::select('SELECT c.*, p.state, p.city, p.address, p.zipcode, p.phone, u.email FROM `companies` as c
                                    LEFT JOIN technicians t ON c.id = t.company_id
                                    LEFT JOIN profiles p  ON c.user_id = p.user_id
                                    LEFT JOIN users u  ON c.user_id = u.id
                                    WHERE t.user_id = ' . $user_id . '
                                    ');
            if (!empty($companys)) {
                return $companys[0];
            }
        }
        return null;
    }

    public function getSelectedCompany($user_id) {
        if (!empty($user_id)) {
            $companys = DB::select('SELECT c.id, c.user_id, c.name, c.logo, AVG(COALESCE(r.point ,0)) AS point, COUNT(r.point) as count FROM companies as c
                                    LEFT JOIN ratings r ON r.company_id = c.id
                                    WHERE c.id  IN (
                                        SELECT s.company_id FROM selecteds s
                                        LEFT JOIN orders o ON o.id = s.order_id
                                                            AND o.status = "active"
                                        WHERE o.poolowner_id = ' . $user_id . '
                                        AND s.status = "pending" OR s.status = "active" OR s.status = "pause"
                                    )
                                    AND c.status = "active-verified"
                                    GROUP BY c.id
                                    ');
            return $companys;
        }
        return [];
    }

    public function pausePoolownerService($order_id, $company_id) {
        DB::statement('UPDATE `selecteds` SET `status`= "pause"
                        WHERE order_id = ' . $order_id . '
                        AND company_id = ' . $company_id . '
                            ');
    }

    public function removeAllSelectCompany($user_id, $company_id, $check = true) {
        $result = DB::statement('UPDATE `selecteds` SET `status`= "inactive"
                                WHERE `order_id` IN (
                                    SELECT o.id FROM orders o
                                    WHERE o.poolowner_id = ' . $user_id . '
                                )
                            ');
        try {
            if ($result && $check) {
                $company = $this->getCompanyById($company_id);
                $this->removeAllScheduleCompanyByPoolowner($user_id, $company_id);
                $content = 'Customers remove for your service';
                Mail::send('emails.remove-company', compact('company'), function($message)
                        use ($company, $content) {
                    $message->subject($content);
                    $message->to($company->email);
                });
                $this->notification->saveItem($company->user_id, $content, false);
            }
            return true;
        } catch (Exception $e) {
            return false;
        }
        return false;
    }

    public function removeAllScheduleCompanyByPoolowner($poolowner_id, $company_id) {
        return DB::statement('UPDATE `schedules` SET `status`= "closed"
                        WHERE `id` IN(
                            SELECT id FROM(
                                SELECT s.id FROM schedules as s
                                LEFT JOIN orders o ON o.id = s.order_id
                                WHERE s.date >= CURDATE()
                                AND s.status = "checkin" OR s.status = "opening"
                                AND s.company_id = ' . $company_id . '
                                AND o.poolowner_id = ' . $poolowner_id . '
                            ) as arbitraryTableName
                        )'
        );
    }

    public function selectCompany($user_id, $company_id, $status = 'pending') {
        $order = $this->order->where([
                    ['poolowner_id', $user_id],
                    ['status', 'active']
                ])->first();
        if (empty($order)) {
            return false;
        }
        // $this->removeAllSelectCompany($user_id, $company_id, false);
        $selected = new Selected();
        $selected->order_id = $order->id;
        $selected->company_id = $company_id;
        $selected->status = $status;

        $result = $selected->save();

        try {
            if ($result) {
                $company = $this->getCompanyById($company_id);
                $content = 'Customers sign up for your service';
                Mail::send('emails.remove-company', compact('company'), function($message)
                        use ($company, $content) {
                    $message->subject($content);
                    $message->to($company->email);
                });
                $this->notification->saveItem($company->user_id, $content, false);
                return true;
            }
        } catch (Exception $e) {
            return false;
        }
        return false;
    }

    public function activeSelectCompany($id, $status = 'active') {
        return DB::update('UPDATE `selecteds` SET `status`= ' . $status . ' WHERE id =' . $id . '');
    }

    public function getRatingCompany($user_id, $company_id) {
        $rating = $this->rating->where([
                    ['user_id', $user_id],
                    ['company_id', $company_id]
                ])
                ->first();
        if (!empty($rating)) {
            return $rating->point;
        }
        return 0;
    }

    public function saveRatingCompany($user_id, $company_id, $point) {
        $rating = $this->rating->where([
                    ['user_id', $user_id],
                    ['company_id', $company_id]
                ])
                ->first();
        if (!empty($rating)) {
            $rating->point = $point;
        } else {
            $rating = new Rating();
            $rating->user_id = $user_id;
            $rating->company_id = $company_id;
            $rating->point = $point;
        }
        return $rating->save();
    }

    public function customersListBuilder($company_id) {
        return "
            select 
                orders.id, profiles.fullname, profiles.address, profiles.city, profiles.state, profiles.zipcode, profiles.created_at,
                max(case when schedules.status ='opening' then schedules.date end) as nextserveddate,
                max(case when schedules.status ='billing_success' or schedules.status ='billing_failed' then schedules.date end) as lastserveddate
            from profiles
            left join orders on orders.poolowner_id = profiles.user_id
            left join schedules on schedules.order_id = orders.id
            left join companies on companies.id = schedules.company_id
            where companies.user_id = $company_id :where
            group by orders.id, profiles.fullname, profiles.address, profiles.city, profiles.state, profiles.zipcode, profiles.created_at
            :orderby
        ";
    }

    public function getCustomers($company_id, $data = []) {
        $list = $this->customersListBuilder($company_id);
        return $this->common->pagingSort($list, $data, true);
    }

    public function listCustomers($company_id, $data) {
        $list = $this->customersListBuilder($company_id);
        return $this->common->pagingSort($list, $data, true, ['city', 'state', 'fullname', 'profiles.created_at', 'profiles.zipcode', "lastserveddate" => "(case when schedules.status ='billing_success' or schedules.status ='billing_failed' then schedules.date end)"])->toJson();
    }

    public function getServiceOffers($user_id) {
        $results = $this->company->where('user_id', $user_id)->select('services')->first();
        return $results->services;
    }

    /* services: ["weekly_cleaning", "deep_cleaning", "pool_spa_repair"] */
    public function changeServiceOffer($data) {
        $user = Auth::user();
        $company = $this->company->where('user_id', $user->id)->first();
        $company->services = $data['services'];
        return $company->save();
    }

    // Offer from customers
    public function listOfferFromPoolownerBuilder($user_id) {
        return "select orders.*, selecteds.id as offer_id, selecteds.status as offer_status from orders 
          left join selecteds on selecteds.order_id = orders.id
          left join companies on companies.id = selecteds.company_id
          where companies.user_id = $user_id and selecteds.status <> 'inactive' :orderby";
    }
    
    public function convertOfferObject($obj) {
        if ($obj) {
            for ($i = 0; $i < count($obj); $i++) {
                $obj[$i]->services = $this->common->getServiceByKeys(json_decode($obj[$i]->services));
                $obj[$i]->zipcode = json_decode($obj[$i]->zipcode)[0];
            }
        }
        return $obj;
    }
    
    public function getOfferFromPoolowner($user_id, $data = []) {
        $obj = $this->listOfferFromPoolownerBuilder($user_id);
        $obj = $this->common->pagingSort($obj, $data, true);
        return $this->convertOfferObject($obj);
    }
    
    public function listOffers($id, $data) {
        $obj = $this->listOfferFromPoolownerBuilder($id);
        $obj = $this->common->pagingSort($obj, $data, true, ['zipcode'=>'json_extract(orders.zipcode,\'$[0]\')', 'services'=>'json_extract(orders.services,\'$\')']);
        return $this->convertOfferObject($obj)->toJson();
    }

    public function acceptDenyOffer($data) {
        $user = Auth::user();
        $poolowner = $this->getPoolownerFromOffer($data['id'])->first();
        $obj = $this->selected->find($data['id']);
        $obj->status = $data['status'];
        DB::beginTransaction();
        try {
            $obj->update();
            if($obj->status=='denied') {
                $data = [
                    'email' => [$user->email, $poolowner->email],
                    'subject' => 'Service Notification',
                    'data' => ['status' => $obj->status]
                ];
                $this->common->sendmail('emails.offer-notification', $data);
            }
            $this->notification->saveItem($user->id, 'Offer from ' . $poolowner->email . ' was ' . $obj->status, 0);
            DB::commit();
            return true;
        } catch (Exception $e) {
            DB::rollback();
            return false;
        }
    }
    
    public function getPoolownerFromOffer($id) {
        return DB::table('users')
            ->leftJoin('orders', 'orders.poolowner_id', 'users.id')
            ->leftJoin('selecteds', 'selecteds.order_id', 'orders.id')
            ->where('selecteds.id', $id)
            ->where('selecteds.status', 'pending');
    }

}
