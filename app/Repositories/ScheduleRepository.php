<?php

namespace App\Repositories;

use App\Models\Schedule;
use Illuminate\Support\Facades\DB;

class ScheduleRepository implements ScheduleRepositoryInterface {

    protected $schedule;    

    public function __construct(Schedule $schedule)
    {
        $this->schedule = $schedule;
    }

    public function getAllScheduleInWeek($technician_id){
        $schedules = DB::select('SELECT s.*, DAYOFWEEK(s.date)dayOfWeek, p.address, p.city, p.zipcode  FROM schedules as s
                                    LEFT JOIN orders o ON o.id = s.order_id
                                    LEFT JOIN profiles p ON p.user_id = o.user_id
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

}