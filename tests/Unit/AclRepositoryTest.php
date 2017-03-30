<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
//use Illuminate\Foundation\Testing\DatabaseTransactions;

class AclRepositoryTest extends TestCase {

    private $repository;
    private $faker;

    public function __construct() {
        $user = new \App\Models\User;
        $group = new \App\Models\Group;
        $permission = new \App\Models\Permission;
        $this->repository = new \App\Repositories\AclRepository($user, $group, $permission);
        $this->faker = \Faker\Factory::create();
    }

    public function createDummyData() {
        $this->repository->createGroup('gp1', 'group1');
        $this->repository->createGroup('gp2', 'group2');
        $this->repository->createGroup('gp3', 'group3');
        $this->repository->createPermission('permission 1', 'psm1');
        $this->repository->createPermission('permission 2', 'psm2');
        $this->repository->createPermission('permission 3', 'psm3');
        $this->repository->createPermission('permission 4', 'psm4');
        $this->repository->user->create([
            'email' => $this->faker->email,
            'password' => \Hash::make($this->faker->password),
            'status' => 'active'
        ]);
    }

    public function test_attach_detachPermission() {
        //$this->createDummyData();

        $group = $this->repository->group->first();
        $permission = $this->repository->permission->first();
        $user = $this->repository->user->first();

        $result = $this->repository->groupAttachPermissions($group->id, $permission->id);
        if ($result === null)
            $result = 1;
        $this->assertEquals($result, 1);

        $result = $this->repository->attachUserToGroup($group->id, $user->id);
        if ($result === null)
            $result = 1;
        $this->assertEquals($result, 1);

        $result = $this->repository->userGetPermissions($user->id);
        $this->assertNotEmpty($result);

        $result = $this->repository->userHasPermission($user->id, $permission->alias);
        $this->assertTrue($result);

        $result = $this->repository->groupDettachPermissions($group->id, $permission->id);
        if ($result === null)
            $result = 1;
        $this->assertEquals($result, 1);

        $result = $this->repository->dettachUserFromGroup($group->id, $user->id);
        if ($result === null)
            $result = 1;
        $this->assertEquals($result, 1);
    }

}
