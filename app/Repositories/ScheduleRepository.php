<?php

namespace App\Repositories;

use App\Models\Order;
use App\Models\Schedule;

use Illuminate\Support\Facades\DB;
use App\Repositories\BillingInfoRepositoryInterface;
use App\Repositories\CompanyRepositoryInterface;

class ScheduleRepository implements ScheduleRepositoryInterface {

    protected $schedule;    
    protected $common;
    protected $billing;    
    protected $company;    

    public function __construct(Schedule $schedule, BillingInfoRepositoryInterface $billing, CompanyRepositoryInterface $company)
    {
        $this->schedule = $schedule;        
        $this->common = app('App\Common\Common');
        $this->billing = $billing;
        $this->company = $company;

    }

    public function getAllScheduleInWeek($technician_id){
        $schedules = DB::select('SELECT s.*, DAYOFWEEK(s.date) dayOfWeek, p.address, p.city, p.zipcode, p.lat, p.lng, p.fullname  FROM schedules as s
                                    LEFT JOIN orders o ON o.id = s.order_id
                                    LEFT JOIN profiles p ON p.user_id = o.poolowner_id
                                    WHERE DATE(s.date) < (NOW() + INTERVAL 6 DAY)
                                    AND DATE(s.date) > (NOW() - INTERVAL 1 DAY)
                                    AND s.status NOT IN ("closed")
                                    AND s.technican_id = '.$technician_id.'
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
                            LEFT JOIN orders o ON u.id = o.poolowner_id
                            LEFT JOIN schedules s ON s.order_id = o.id
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
            if($status=='billing_success'){
                if(!$this->chargeForPoolowner($schedule->order_id,$status)){
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
                if($status=='billing_success'){
                    $schedule_new = $schedule->replicate();
                    unset($schedule_new->id);
                    $schedule_new->status = "opening";
                    $date = $schedule->date->modify('+1 week');
                    $schedule_new->date = $date->format('Y-m-d H:i:s');
                    $schedule_new->save();
                }else{
                    $this->company->pausePoolownerService($schedule->order_id, $schedule->company_id);
                }
                return $schedule;
            }
        }
        return null;
    }
    

    private function chargeForPoolowner($order_id,$status){
        $order = Order::find($order_id)->first();
        if(isset($order)){
            return $this->billing->chargeForPayment($order->poolowner_id, $order->price);
        }
        return false;
    }

    public function getAllScheduleByPoolowner($user_id){
        $services = DB::select('SELECT s.*, o.services, o.price  FROM schedules as s
                            LEFT JOIN orders o ON o.id = s.order_id
                            WHERE o.poolowner_id = '.$user_id.'
                            AND s.status NOT IN ("closed")
                            ORDER BY `date` DESC
                            ');
                            
        if(isset($services)){
            foreach($services as $service){
                $keys = json_decode($service->services, true);
                $service->service_name = $this->common->getServiceByKeys($keys);

                $service->dateFormat = $this->common->formatDate($service->date);
            }
            return $services;
        }
        return [];
    }

    public function getTimePoolownerNotuse($user_id){
         $services = DB::select('SELECT s.*, o.services, o.price  FROM schedules as s
                            LEFT JOIN orders o ON o.id = s.order_id
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

}