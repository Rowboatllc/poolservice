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
