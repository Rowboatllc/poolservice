<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
	protected $table = 'groups';
        
        public function permissions() {
            return $this->belongsToMany('App\Models\Permissions', 'group_permission', 'group_id', 'permission_id');

        }
        
        public function users() {
            return $this->belongsToMany('App\Models\User', 'group_user', 'group_id', 'user_id');

        }
}
