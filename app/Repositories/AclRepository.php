<?php

namespace App\Repositories;

use App\Models\User;
use App\Models\Group;
use App\Models\Permission;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class AclRepository {
    
    private $user;
    private $group;
    private $permission;
    
    public function __construct(User $user, Group $group, Permission $permission ) {
        $this->user = $user;
        $this->group = $group;
        $this->permission = $permission;
    }
    
    public function createGroup($name, $description='') {
        $find = $this->group->where('name',$name)->first();
        if(isset($find)){
            var_dump(true);            
            return false;
        }else{
            $group = new Group();
            $group->name = $name;
            $group->description = $description;
            var_dump($group);
            return  $group->save();
        }
    }
    
    public function attachUserToGroup($group_id, $user_id) {
        $group = $this->group->find($group_id);
        $user = $this->user->find($user_id);
        if(isset($group)&&isset($user)){
            if(!$group->users->contains($users->id))
                return $group->users()->attach($user->id);
        }
        return false;        
    }
    
    public function dettachUserFromGroup($group_id, $user_id) {
        $group = $this->group->find($group_id);
        if(isset($group)){
            if(!$group->users->contains($user_id))
                return 1;
            return $group->users()->detach($user_id);
        }
        return 0;
    }
    
    public function userGetPermissions($user_id) {
        // $user = Auth::user();
        if(isset($user_id)){
            $results = DB::select('SELECT p.alias FROM permissions p 
                                LEFT JOIN group_permission gp ON p.id=gp.permission_id 
                                LEFT JOIN groups g ON gp.group_id = g.id
                                WHERE g.id  IN (
                                    SELECT ug.group_id FROM users u
                                    LEFT JOIN user_group ug ON u.id = ug.user_id
                                    WHERE u.id = '.$user_id.'
                                )');
            $alias = [];
            foreach($results as $permission){
                $alias[] = $permission->alias;
            }
            return $alias;
        }
        return [];
    }
    
    public function userHasPermission($user_id, $alias) {
        $aliass = $this->userGetPermissions($user_id);
        return in_array($alias,$aliass);
    }
    
    public function createPermission($name, $alias, $description='') {
        $find = $this->permission->where('alias',$alias)->first();
        if(isset($find)){
            return 0;
        }else{
            $permission = new Permission();
            $permission->name = $name;
            $permission->alias = $alias;
            $permission->description = $description;
            return  $permission->save();
        }
    }
    
    public function groupAttachPermissions($group_id, $permission_id) {
        $group = $this->group->find($group_id);
        $permission = $this->permission->find($permission_id);
        if(isset($group)&&isset($permission)){
            if(!$group->permissions->contains($permission->id))
                return $group->permissions()->attach($permission->id);
        }
        return 0;
    }
    
    public function groupDettachPermissions($group_id, $permission_id) {
        $group = $this->group->find($group_id);
        if(isset($group)){
            if(!$group->permissions->contains($permission_id))
                return 1;
            return $group->permissions()->detach($permission_id);
        }
        return 0;
    }
    
    public function cachePermission($permissions) {
        Session::put('user_permission',$permissions);
    }

    public function deleteCachePermission() {
        Session::forget('user_permission');
    }
    
}
