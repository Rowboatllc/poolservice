<?php

namespace App\Repositories;

use App\Models\Notification;
use DB;

class NotificationRepository implements NotificationRepositoryInterface {

    protected $notification;
    protected $common;

    public function __construct(Notification $notification) {
        $this->notification = $notification;
        $this->common = app('App\Common\Common');
    }

    public function listBuilder($id) {
        return DB::table('notifications')->where('user_id', $id);
    }
    
    public function getList($id, $data=[]) {
        $list = $this->listBuilder($id);
        return $this->common->pagingSort($list, $data);
    }

    // Ajax from here
    public function listItems($id, $data) {
        $list = $this->listBuilder($id);
        return $this->common->pagingSort($list, $data)->toJson();
    }
    
    public function getItem($id, $data) {
        $obj = $this->notification->find($data['id']);
        if(!empty($data['isOpened'])) {
           $obj->opened = 1;
           $obj->save();
        }
        return $obj;
    }
    
    public function saveItem($user_id, $content, $opened) {
        $notification = new Notification();
        $notification->user_id = $user_id;
        $notification->content = $content;
        $notification->opened = $opened;
        return $notification->save();
    }

    public function updateItem($data) {
        $obj = $this->notification->find($data['id']);
        $obj->opened = $data['status'];
        return $obj->save();
    }

    public function removeItem($data) {
        $obj = $this->notification;
        $obj = is_array($data['id']) ? 
                $obj->whereIn('id', $data['id']) :
                $obj->find($data['id']);
        return $obj->delete();
    }
    
    public function totalUnread($id) {
        return count($this->listBuilder($id)->get());
    }

}
