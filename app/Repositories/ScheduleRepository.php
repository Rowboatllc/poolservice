<?php

namespace App\Repositories;

use App\Models\Schedule;
use Illuminate\Support\Facades\DB;

class ScheduleRepository implements ScheduleRepositoryInterface {

    protected $schedule;    
    protected $common;    

    public function __construct(Schedule $schedule)
    {
        $this->schedule = $schedule;        
        $this->common = app('App\Common\Common');

    }

    public function getAllScheduleInWeek($technician_id){
        $schedules = DB::select('SELECT s.*, DAYOFWEEK(s.date)dayOfWeek, p.address, p.city, p.zipcode  FROM schedules as s
                                    LEFT JOIN orders o ON o.id = s.order_id
                                    LEFT JOIN profiles p ON p.user_id = o.poolowner_id
                                    WHERE WEEKOFYEAR(date) = WEEKOFYEAR(CURDATE())
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
            return $schedule->save();
        }
        return 0;
    }

    public function updateSchedule(array $array, $status){
        $schedule_id = $array['schedule_id'];
        $schedule = $this->schedule->find($schedule_id);
        if(isset($schedule)){
            $schedule->status = $status;
            $schedule->comment = $array['comment'];
            $cleaning_steps	= [];
            for($i=1;$i<=6;$i++){
                if(isset($array['step'.$i]) && $array['step'.$i]=="on")
                    $cleaning_steps[] = $i;
            }
            $schedule->cleaning_steps = $cleaning_steps;
            
            if($schedule->save()){
                return $schedule;
            }
        }
        return null;
    }

    public function getAllScheduleByPoolowner($user_id){
        $services = DB::select('SELECT s.*, o.services, o.price  FROM schedules as s
                            LEFT JOIN orders o ON o.id = s.order_id
                            WHERE o.poolowner_id = '.$user_id.'
                            ORDER BY `date` DESC
                            ');
        if(isset($services)){
            foreach($services as $service){
                $keys = json_decode($service->services, true);
                $service->service_name = $this->common->getServiceByKeys($keys);
            }
            return $services;
        }
        return [];
    }

}