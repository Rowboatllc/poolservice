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
        $schedules = DB::select('SELECT *, DAYOFWEEK(s.date) dayOfWeek FROM schedules as s
                                    WHERE WEEKOFYEAR(date) = WEEKOFYEAR(CURDATE())
                                    AND s.technican_id = '.$technician_id.'
                                    ORDER BY `dayOfWeek` ASC
                                ');
        $result = ["monday" => [], "tuesday" => [], "wednesday" => [], "thursday" => [], "friday" => []];                          
        if(isset($schedules)){
            foreach($schedules as $schedule){
                switch ($schedule->dayOfWeek) {
                    case 2:
                        $result["monday"][] = $schedule;
                        break;
                    case 3:
                        $result["tuesday"][] = $schedule;
                        break;
                    case 4:
                        $result["wednesday"][] = $schedule;
                        break;
                    case 5:
                        $result["thursday"][] = $schedule;
                        break;
                    case 6:
                        $result["friday"][] = $schedule;
                        break;
                }
            }
        }

        return $result;                          
        
    }

}