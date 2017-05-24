<?php

namespace App\Observers;

use App\Models\Technician;
use App\Repositories\AclRepository;
      
class TechnicianObserver {
    private $mygroup = 4;
    public function creating(Technician $obj) {
        $acl = new AclRepository;
        $acl->attachUserToGroup($this->mygroup, $obj->user_id);
    }

    public function deleting(Technician $obj) {
        $acl = new AclRepository;
        $repo = app('App\Repositories\ScheduleRepository');
        $acl->dettachUserFromGroup($this->mygroup, $obj->user_id);
        $repo->whenRemoveTechnician($obj->user_id);
    }

}
