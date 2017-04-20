<?php

namespace App\Repositories;
use App\Models\Notification;

class NotificationRepository implements NotificationRepositoryInterface {

    protected $notification;    

    public function __construct(Notification $notification)
    {
        $this->notification = $notification;
    }

    public function saveNotification($user_id, $content, $opened){
        $notification = new Notification();
        $notification->user_id = $user_id;
        $notification->content = $content;
        $notification->opened = $opened;
        
        return $notification->save();
    }

}