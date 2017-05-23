<?php

namespace App\Repositories;

use App\Models\Order;
use App\Models\Schedule;
use App\Models\Selected;

use Illuminate\Support\Facades\DB;
use App\Repositories\BillingInfoRepositoryInterface;
use App\Repositories\CompanyRepositoryInterface;

class ScheduleRepository implements ScheduleRepositoryInterface {

    protected $schedule;    
    protected $common;
    protected $billing;    
    protected $company;    
    protected $selected;    

    public function __construct(Schedule $schedule, Selected $selected, BillingInfoRepositoryInterface $billing, CompanyRepositoryInterface $company)
    {
        $this->schedule = $schedule;        
        $this->common = app('App\Common\Common');
        $this->billing = $billing;
        $this->company = $company;
        $this->selected = $selected;
        
    }

    public function getAllScheduleInWeek($technician_id){
        $schedules = DB::select('SELECT s.*, DAYOFWEEK(s.date) dayOfWeek, p.address, p.city, p.zipcode, p.lat, p.lng, p.fullname  FROM schedules as s
                                    LEFT JOIN selecteds se ON se.id = s.selected_id
                                    LEFT JOIN orders o ON o.id = se.order_id
                                    LEFT JOIN profiles p ON p.user_id = o.poolowner_id
                                    WHERE DATE(s.date) < (NOW() + INTERVAL 6 DAY)
                                    AND DATE(s.date) > (NOW() - INTERVAL 1 DAY)
                                    AND s.status NOT IN ("closed")
                                    AND s.technician_id = '.$technician_id.'
                                    ORDER BY `dayOfWeek` ASC
                                    ');
        $result = array(
            array("name" => "Monday", "value" => []),
            array("name" => "Tuesday", "value" => []),
            array("name" => "Wednesday", "value" => []),
            array("name" => "Thursday", "value" => []),
            array("name" => "Friday", "value" => [])
        );                          
        if(isset($schedules)){
            foreach($schedules as $schedule){
                if($schedule->status =='billing_success' || $schedule->status == 'billing_error'){
                    $schedule->status = 'complete';
                }

                $schedule->dateFormat = $this->common->formatDate($schedule->date);

                switch ($schedule->dayOfWeek) {
                    case 2:
                        $result[0]["value"][] = $schedule;
                        break;
                    case 3:
                        $result[1]["value"][] = $schedule;
                        break;
                    case 4:
                        $result[2]["value"][] = $schedule;
                        break;
                    case 5:
                        $result[3]["value"][] = $schedule;
                        break;
                    case 6:
                        $result[4]["value"][] = $schedule;
                        break;
                }
            }
            
        }
        $temp = [];
        $temp2 = [];
        $check = false;
        $now = new \DateTime();
        $date = $now->format('l');
        foreach($result as $res){
            if($res['name']==$date||$check){
                $check = true;
                $temp2[] = $res;
            }else{
                $temp[] = $res;
            }
        }
        $result = array_merge($temp2, $temp);
        return $result;                          
        
    }

    public function getPoolownerInSchedule($schedule_id){
        $users = DB::select('SELECT u.* FROM users as u
                            LEFT JOIN orders o ON o.poolowner_id = u.id
                            LEFT JOIN selecteds se ON se.order_id = o.id
                            LEFT JOIN schedules s ON s.selected_id = se.id
                            WHERE s.id = '.$schedule_id.'
                            ');
        if(isset($users))
            return $users[0];
        else
            return null;
    }
    public function updateStatus($schedule_id, $status){
        $schedule = $this->schedule->find($schedule_id);
        if(isset($schedule)){
            $schedule->status = $status;
            $schedule->date = new \DateTime();
            return $schedule->save();
        }
        return 0;
    }

    public function updateSchedule(array $array, $status){
        $schedule_id = $array['schedule_id'];
        $schedule = $this->schedule->find($schedule_id);
        if(isset($schedule)){
            $selected = $this->selected->find($schedule->selected_id);
            if($selected){
                $order = Order::find($selected->order_id);

                if($status=='billing_success'){
                    if(!$this->chargeForPoolowner($schedule->order_id)){
                        $status='billing_error';
                    }
                }
                $schedule->status = $status;
                $schedule->comment = $array['comment'];
                $cleaning_steps	= [];
                for($i=1;$i<=6;$i++){
                    if(isset($array['step'.$i]) && $array['step'.$i]=="on")
                        $cleaning_steps[] = $i;
                }
                $schedule->cleaning_steps = $cleaning_steps;
                $schedule->date = new \DateTime();
                if($schedule->save()){
                    if($status=='billing_success'||$status=='unable'){
                        if(isset($order)){
                            if (in_array("weekly_learning", $order->services)){                            
                                $schedule_new = $schedule->replicate();
                                unset($schedule_new->id);
                                $schedule_new->status = "opening";
                                $date = $schedule->date->modify('+1 week');
                                $schedule_new->date = $date->format('Y-m-d H:i:s');
                                $schedule_new->save();
                            }
                        }
                    }else if($status=='billing_error'){
                        $this->company->pausePoolownerService($selected->order_id, $selected->company_id);
                    }
                    return $schedule;
                }
            }
            
        }
        return null;
    }
    

    private function chargeForPoolowner($order){
        if(isset($order)){
            return $this->billing->chargeForPayment($order->poolowner_id, $order->price);
        }
        return false;
    }

    public function getQueryScheduleByPoolowner($user_id){
        return 'SELECT s.*, o.services, o.price  FROM schedules as s
                            LEFT JOIN selecteds se ON se.id = s.selected_id
                            LEFT JOIN orders o ON o.id = se.order_id
                            WHERE o.poolowner_id = '.$user_id.'
                            AND s.status NOT IN ("closed")
                            ORDER BY `date` DESC
                            ';
    }

    public function getAllScheduleByPoolownerNotJson($user_id, $data=[]) {
        $list = $this->getQueryScheduleByPoolowner($user_id);
        return $this->convertData($this->common->pagingSort($list, $data, true, [], 10));
    }

    public function getAllScheduleByPoolowner($user_id, $data) {
        $list = $this->getQueryScheduleByPoolowner($user_id);
        return $this->convertData($this->common->pagingSort($list, $data, true, [], 10))->toJson();
    }

    private function convertData($services){
        if(isset($services)){
            foreach($services as $service){
                $keys = json_decode($service->services, true);
                $service->service_name = $this->common->getServiceByKeys($keys);
                $service->dateFormat = $this->common->formatDate($service->date);
                if($service->status == 'checkin' || $service->status == 'opening')
                    if(date("Y-m-d",strtotime($service->date)) < date("Y-m-d",strtotime('now'))){
                        $service->status = 'not_services';
                    }
            }
            return $services;
        }
        return [];
    }

    public function getTimePoolownerNotuse($user_id){
         $services = DB::select('SELECT s.*, o.services, o.price  FROM schedules as s
                            LEFT JOIN selecteds se ON se.id = s.selected_id
                            LEFT JOIN orders o ON o.id = se.order_id
                            WHERE o.poolowner_id = '.$user_id.'
                            AND s.status IN ("unable", "billing_success", "billing_error")
                            AND s.date <= NOW()
                            AND s.date > (NOW() - INTERVAL 1 DAY)
                            ORDER BY `date` DESC
                            ');
        $time = 5;
        $now = new \DateTime();
        $time_now = date_format($now, 'Y-m-d H:i:s');
        if(isset($services)){
            foreach($services as $service){
                $temp = (strtotime($time_now)-strtotime($service->date))/60/60;
                if($temp > 0 && $temp <=4 && $temp <= $time){
                    $time = $temp;
                }
            }            
        }
        if($time==5)
            return 0;
        return 4-$time;
    }
    
    public function getAllPoolownerNotAssigned($company_id){
        return DB::table('profiles')
            ->join('orders', 'orders.poolowner_id', '=', 'profiles.user_id')
            ->join('selecteds', 'selecteds.order_id', '=', 'orders.id')
            ->where('selecteds.company_id', $company_id)
            ->where('selecteds.status', 'active')
            ->where('orders.status', 'active')
            ->select('profiles.user_id','profiles.fullname','profiles.address','profiles.city','profiles.state','profiles.zipcode','profiles.lat','profiles.lng','profiles.phone','profiles.avatar', 'selecteds.id')
            ->get();
    }

    public function updateStatusSelected($selected_id, $status = 'active', $dayofweek = null, $technician_id = null){
        $selected = $this->selected->find($selected_id);
        if(isset($selected)){
            if($dayofweek){
                $selected->dayofweek = $dayofweek;
            }
            if($technician_id){
                $selected->technician_id = $technician_id;
            }
            $selected->status = $status;
            return $selected->save();
        }
        return false;
    }

// date format string Y-m-d
    public function assignTechnicianToPoolowner($selected_id, $technician_id, $date){
        try{
            $selected = $this->selected->find($selected_id);
            if(isset($selected)){
                if(!$selected->technician_id){

                    $schedules = DB::table('schedules')
                                    ->where('technician_id', $technician_id)
                                    ->whereDate('date', $date)
                                    ->get();
                    if(count($schedules)<16){
                        $datetime = new \DateTime($date);
                        $dayofweek = $datetime->format('N');
                        $dayofweek ++;
                        $selected->technician_id = $technician_id;
                        $selected->dayofweek = $dayofweek;
                        $selected->status = 'assigned';

                        if($selected->save()){
                            $sechedule = new Schedule;
                            $sechedule->selected_id = $selected_id;
                            $sechedule->technician_id = $technician_id;
                            $sechedule->date = $date;
                            $sechedule->status = "opening";

                            return $sechedule->save();
                        }
                    }
                }          
            }
        }catch (Exception $e) {
            return false;
        }
        return false;
        
    }

// date format string Y-m-d
    public function notAvailable($technician_id, $date){
        try{

            $selecteds = DB::table('selecteds')
                    ->leftJoin('schedules', 'schedules.selected_id', '=', 'selecteds.id')
                    ->where('schedules.technician_id', $technician_id)
                    ->whereIn('schedules.status', ['opening','checkin'])
                    ->whereDate('schedules.date', $date)
                    ->update(['selecteds.status' => "active"]);

            $schedules = DB::table('schedules')
                    ->where('technician_id', $technician_id)
                    ->whereDate('date', $date)
                    ->whereIn('status', ['opening','checkin'])
                    ->update(['status' => "closed"]);

            if($selecteds>0 &&$schedules){
                return true;
            }

        }catch (Exception $e) {
            return false;
        }
        return false;
    }

    public function notAssignOnePoolowner($schedule_id){
        try{
            $schedule = $this->schedule->find($schedule_id);
            if(isset($schedule)){
                   $schedule->status = "closed";
                   if($schedule->save()){
                       $selected = $this->selected->find($schedule->selected_id);
                       if(isset($selected)){
                           $selected->status = "active";
                           $selected->dayofweek = null;
                           $selected->technician_id = null;

                           return $selected->save();
                       }
                   }
            }
        }catch (Exception $e) {
            return false;
        }
        return false;
        
    }

}