<?php

namespace App\Observers;

use App\Models\User;
use App\Repositories\ApiToken;

class UserObserver {

    public function created(User $user) {
//        $token = new ApiToken;
//        $token->create($user->id);
    }

    public function deleting(User $user) {
//        $token = new ApiToken;
//        $token->deleteByUserid($user->id);
    }

}
