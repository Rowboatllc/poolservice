<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
	protected $table = 'groups';

    protected $fillable = [
        'name', 'description'
    ];   
    public function permissions() {
        return $this->belongsToMany('App\Models\Permission', 'group_permission', 'group_id', 'permission_id');

    }
    
    public function users() {
        return $this->belongsToMany('App\Models\User', 'user_group', 'group_id', 'user_id');

    }
}
