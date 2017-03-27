<?php

namespace App\Repositories;

class AclRepository {
    
    public function __construct() {
    }
    
    public function createGroup($data) {
        
    }
    
    public function attachUserToGroup($group, $user) {
        
    }
    
    public function dettachUserFromGroup($group, $user) {
        
    }
    
    public function userGetPermissions($user) {
        
    }
    
    public function userHasPermission($user, $permission) {
        return true;
    }
    
    public function createPermission($data) {
        
    }
    
    public function groupAttachPermissions($group, $permission) {
        
    }
    
    public function groupDettachPermissions($group, $permission) {
        
    }
    
    public function cachePermission($permission) {
        
    }
    
}
