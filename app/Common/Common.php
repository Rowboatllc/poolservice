<?php

namespace App\Common;

use App\Repositories\ApiToken;
use Illuminate\Support\Facades\Storage;
use Request;
use Auth;
use Mail;
use DateInterval;
use DatePeriod;
use DateTime;
use App\Common\Pagination;

class Common {
    use Pagination;
    public function __construct() {}

    public function getEloquentById($eloquent, $id) {
        $result = $eloquent->find($id);
        return $result ? $eloquent->find($id) : $this->getDefaultEloquentAttibutes($eloquent);
    }

    public function getDefaultEloquentAttibutes($eloquent) {
        $arr = $eloquent->getFillable();
        foreach ($arr as $item) {
            $eloquent->setAttribute($item, '');
        }
        return $eloquent;
    }
    
    public function numberOfNotification() {
        $user = Auth::user();
        $result = \DB::table('notifications')
            ->where([
                ['user_id', $user->id],
                ['opened', 0]
            ])
            ->select(\DB::raw('count(id) as n'))
            ->first();
        return $result->n;
    }

    public function uploadResizeImage($imageFolder, $inputname="avatar") {
        //$imageFolder = 'uploads/profile';
        $file = Request::file($inputname);
        $extension = $file->extension();
        $user = Auth::user();
        $image_name = md5($user->email) . '.' . $extension;
        $filename = $imageFolder . '/' . $image_name;

        if (!($file->isValid()) || $extension == 'exe' || !in_array($extension, ['jpg', 'png', 'jpeg'])) {
            return false;
        }

        //resize
        //$result = Image::make($avatarFolder.'/'.$image_name)->resize(100, 100)->save($avatarFolder.'/'.$image_name);
        try {
            if (Storage::disk('uploads')->exists($filename))
                Storage::disk('uploads')->delete($filename);
            $result = Storage::disk('uploads')->putFileAs($imageFolder, $file, $image_name);
            return $filename;
        } catch (Exception $e) {
            return false;
        }
    }

    public function uploadImage($imageFolder, $inputname, $rename) {
        //$imageFolder = 'uploads/profile';
        $file = Request::file($inputname);
        $extension = $file->extension();
        $image_name = $rename . '.' . $extension;
        $filename = $imageFolder . '/' . $image_name;
        if (!($file->isValid()) || $extension == 'exe' || !in_array($extension, ['jpg', 'png', 'jpeg'])) {
            return false;
        }
        try {
            if (Storage::disk('uploads')->exists($filename))
                Storage::disk('uploads')->delete($filename);
            $result = Storage::disk('uploads')->putFileAs($imageFolder, $file, $image_name);
            return $filename;
        } catch (Exception $e) {
            return false;
        }
    }
    
    public function responseJson($result = false, $code = 200, $message = '', $param=[]) {
        $data = [
            'success' => $result,
            'message' => $message,
            'code' => $code
        ];
        $param = array_merge($data, $param);
        return response()->json($param, $code)->header('Content-Type', 'application/json');
    }

    public function sendmail($tpl, $info) {
        Mail::send($tpl, $info['data'], function($message)
                use ($info) {
            $message->subject($info['subject']);
            $message->to($info['email']);
        });
    }
    
    public function getUserByToken() {
        $api = new ApiToken;
        return $api->getUserByToken();
    }

    public function checkValidZipcode($code) {
        return $code;
    }

    public function getSupportedStates() {
        return [];
    }
    
    public function getAllServices() {
        return [
            'weekly_learning' => 'Weeklys learning',
            'deep_cleaning' => 'Deep cleaning',
            'pool_spa_repair' => 'Pool spa repair',
        ];
    }
    
    public function getServiceByKeys($keys) {
        $all = $this->getAllServices();
        $arr = [];
        foreach($keys as $key=>$item){
            $arr[] = $all[$item];
        }
        return implode(' | ',$arr);
    }
    
    public function formatDate($date){
        if(!isset($date)){
            return null;
        }

        $date_new = new \DateTime($date);
        return $date_new->format('m-d-Y');
    }

    public static function getDateOfWeekDay($day) {
        $weekDays = array(
        'Sunday',
        'Monday',
        'Tuesday',
        'Wednesday',
        'Thursday',
        'Friday',
        'Saturday',
        );

        $dayNumber = array_search($day, $weekDays);
        $currentDayNumber =  date('w', strtotime('today'));

        if ($dayNumber > $currentDayNumber) {
            return date('Y-m-d', strtotime($day));
        } else {
            return date('Y-m-d', strtotime($day) - 604800);
        }
    }

    public static function getAllDayOfCurrentYearMonth($month,$year)
    {
        $list=array();
        $start_date = "01-".$month."-".$year;
        $start_time = strtotime($start_date);
        $end_time = strtotime("+1 month", $start_time);
        for($i=$start_time; $i<$end_time; $i+=86400){
            $list[] = date('Y-m-d-D', $i);
        }

        return $list;
    }

    public static function getDayWeeksOfMonth($month,$year)
    {
        $month = intval($month);				//force month to single integer if '0x'
        $suff = array('st','nd','rd','th','th','th'); 		//week suffixes
        $end = date('t',mktime(0,0,0,$month,1,$year)); 		//last date day of month: 28 - 31
        $start = date('w',mktime(0,0,0,$month,1,$year)); 	//1st day of month: 0 - 6 (Sun - Sat)
        $last = 7 - $start; 					//get last day date (Sat) of first week
        $noweeks = ceil((($end - ($last + 1))/7) + 1);		//total no. weeks in month
        // $output = "";	
        $arr=array();					//initialize string		
        $monthlabel = str_pad($month, 2, '0', STR_PAD_LEFT);
        for($x=1;$x<$noweeks+1;$x++){	
            if($x == 1){
                $startdate = "$year-$monthlabel-01";
                $day = $last - 6;
            }else{
                $day = $last + 1 + (($x-2)*7);
                $day = str_pad($day, 2, '0', STR_PAD_LEFT);
                $startdate = "$year-$monthlabel-$day";
            }
            if($x == $noweeks){
                var_dump($end);
                $enddate = "$year-$monthlabel-$end";
            }else{
                $dayend = $day + 6;
                $dayend = str_pad($dayend, 2, '0', STR_PAD_LEFT);
                $enddate = "$year-$monthlabel-$dayend";
            }

            $days_between=[];
            $start    = new DateTime($startdate);
            $end      = (new DateTime($enddate))->modify('+1 day');
            $interval = new DateInterval('P1D');
            $period   = new DatePeriod($start, $interval, $end);
            
            foreach ($period as $dt) {
                $days_between[]=$dt->format("Y-m-d");
            }
            
            $arr[$x]= $days_between;
            // $output .= "{$x}{$suff[$x-1]} week -> Start date=$startdate End date=$enddate <br />";	
        }
        
        return $arr;
    }

    public static function getKeyDatesFromRange($start, $end, $format = 'Y-m-d') {
        $days   = array();
        $period = new DatePeriod(
            $start, // Start date of the period
            new DateInterval('P1D'), // Define the intervals as Periods of 1 Day
            $end // Apply the interval 6 times on top of the starting date
        );    
        
        foreach ($period as $day)
        {
            $key=date('l', strtotime($day->format($format)));
            if($key!='Sunday' && $key!='Saturday')
            {
                $days[$key] = $day->format($format);
            }            
        }

        return $days;
    }

    public static function getDatesFromRange($start, $end, $format = 'Y-m-d') {
        $days   = array();
        $period = new DatePeriod(
            $start, // Start date of the period
            new DateInterval('P1D'), // Define the intervals as Periods of 1 Day
            $end // Apply the interval 6 times on top of the starting date
        );    
        
        foreach ($period as $day)
        {
            $key=date('l', strtotime($day->format($format)));
            if($key!='Sunday' && $key!='Saturday')
            {
                $days[] = $day->format($format);
            }            
        }

        return $days;
    }

    public static function getCurrentDay($date,$format = 'Y-m-d')
    {
        return date('l', strtotime($date->format($format)));
    }

    // function to geocode address, it will return false if unable to geocode address
    public static function geoCode($address){
    
        // url encode the address
        $address = urlencode($address);
        
        // google map geocode api url
        $url = "http://maps.google.com/maps/api/geocode/json?address={$address}";
    
        // get the json response
        $resp_json = file_get_contents($url);
        
        // decode the json
        $resp = json_decode($resp_json, true);
    
        // response status will be 'OK', if able to geocode given address 
        if($resp['status']=='OK'){
    
            // get the important data
            $lati = $resp['results'][0]['geometry']['location']['lat'];
            $longi = $resp['results'][0]['geometry']['location']['lng'];
            $formatted_address = $resp['results'][0]['formatted_address'];
            
            // verify if data is complete
            if($lati && $longi && $formatted_address){
            
                // put the data in the array
                $data_arr = array();            
                
                array_push(
                    $data_arr, 
                        $lati, 
                        $longi, 
                        $formatted_address
                    );
                
                return $data_arr;
                
            }else{
                return false;
            }
            
        }else{
            return false;
        }
    }
}
