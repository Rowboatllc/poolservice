<?php

namespace App\Observers;

use App\Models\Technician;

class TechnicianObserver {

    public function created(Technician $obj) {
        // Add Teachnician to group
    }

    public function deleting(Technician $obj) {
        // Remove Teachnician from group
    }

}
