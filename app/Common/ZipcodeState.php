<?php

namespace App\Common;

/*use App\Models\User;
use App\Models\Group;
use App\Models\Permission;*/
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class ZipcodeState {

    public $user;
    public $group;
    public $permission;

    public function __construct(){ //User $user, Group $group, Permission $permission) {
        $user = new \App\Models\User;
        $group = new \App\Models\Group;
        $permission = new \App\Models\Permission;
        $this->user = $user;
        $this->group = $group;
        $this->permission = $permission;
    }

    public function getListZipCode() {
        return [
            111,
            70000
        ];
    }

}
