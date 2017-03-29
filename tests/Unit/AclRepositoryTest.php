<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Database\Eloquent\Model;
use App\Repositories\AclRepository;
use Faker;

class AclRepositoryTest extends TestCase{
    
    use DatabaseTransactions;
    private $repository;
    private $faker;
    
    public function __construct() {
        $this->repository = app('App\Repositories\AclRepository');
        $this->faker = Faker\Factory::create();
    }

    public function test_permission(){
        $group_name = 'testabcd';
        $this->repository->createGroup($group_name,'34567899876');

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

