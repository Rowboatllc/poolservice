<?php
function item_link($routename, $label, $attrs, $permissions) {
    $active = in_array($routename, $permissions);
    return $active ? Html::link(route($routename), $label, $attrs) : '';
}

function print_apitoken() {
    $user = Auth::user();
    if(empty($user))
        return;
    $tk = new \App\Repositories\ApiToken;
    $token =  $tk->selectByUserid($user->id);
    if(empty($token))
        return;
    echo $token->api_token;
}

function convertToHoursMins($time, $format = '%02d hours : %02d minutes') {
    if ($time < 1) {
        return;
    }
    $hours = floor($time / 60);
    $minutes = ($time % 60);
    return sprintf($format, $hours, $minutes);
}

function h2m($time, $format = '%02d hours : %02d minutes') { 
    $t = EXPLODE(".", $time); 
    $hours = $t[0]; 
    IF (ISSET($t[1])) { 
        $minutes = floor(($time-$hours)*60);
    } ELSE { 
        $minutes = 0; 
    } 
    return sprintf($format, $hours, $minutes);
}

function convertToStringAfterXHours($time, $format = "h:i A M d, Y") {
    $t = EXPLODE(".", $time); 
    $hours = $t[0]; 
    IF (ISSET($t[1])) { 
        $minutes = floor(($time-$hours)*60);
    } ELSE { 
        $minutes = 0; 
    } 
    return date($format, strtotime('+'.$hours.' hours '.$minutes.' seconds'));
}

function convertDateAvailable($date, $format = "M d, Y") {
    if(!isset($date)){
        return "";
    }
    return date($format, strtotime($date));
}
