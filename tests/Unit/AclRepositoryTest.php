<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Database\Eloquent\Model;
use App\Repositories\AclRepository;
use Faker;
use App\Models\User;
use App\Models\Group;
use App\Models\Permission;

class AclRepositoryTest extends TestCase{

    private $repository;
    private $faker;
    
    public function __construct() {
        $user = new User; $group = new Group ;$permission = new Permission;
        $this->repository = new AclRepository($user, $group, $permission);
        $this->faker = Faker\Factory::create();
    }

    public function test_permission(){
        $group_name = 'Test';
        $group_description = 'Test description';
        $this->repository->createGroup($group_name,$group_description);
        
        // $user_admin = factory(App\Models\User::class)->make();
    }

    public function test_get_permission()
    {
        // $result = $this->repository->userGetPermissions(7);
        // $this->assertNotEmpty($result);
    }

    public function test_has_permission()
    {
        // $result = $this->repository->userHasPermission(7,'delete.admin');
        // $this->assertTrue($result);
    }
}

