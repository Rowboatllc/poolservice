<?php

namespace App\Repositories;

interface ScheduleRepositoryInterface
{
    public function getAllPoolownerNotAssigned($user_id);
    public function updateStatusSelected($selected_id, $status = 'active', $dayofweek = null, $technician_id = null);
    public function assignTechnicianToPoolowner($selected_id, $technician_id, $date);
    public function notAvailable($technician_id, $date);
    public function getUserSchedule($user_id);
    public function getUserScheduleBetweenDate($user_id,$from,$to);
    public function getDayWeeksOfMonth($user_id,$month,$year);
}