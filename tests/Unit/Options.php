<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Repositories\OptionRepository;
use Faker;
use App\Models\Options;

class OptionsTest extends TestCase
{
    private $repository;
    private $faker;
    
    public function __construct() {
        $this->repository = app('App\Repositories\OptionRepository');
        $this->faker = Faker\Factory::create();
    }

    public function test_createOption()
    {
        $key = $this->faker->userName;
        $value = [
            'username' => $this->faker->userName,
            'skype' => $this->faker->userName
        ];
        $result = $this->repository->createOption($key, $value);
        $this->assertNotNull($result);
    }
    
    public function test_getOption()
    {
        $option = Options::first();
        $option = $this->repository->getOption($option->key);
        $this->assertNotEmpty($option);
    }
    
    public function test_updateOption()
    {
        $key = Options::first()->key;
        $value = [
            'onemoreparame' => $this->faker->text(),
            'andmore' => $this->faker->text()
        ];
        $result = $this->repository->updateOption($key, $value);
        $this->assertTrue($result);
    }
    
    public function test_deleteOption()
    {
        $option = Options::first();
        $option = $this->repository->deleteOption($option->key);
        $this->assertTrue($option);
    }
    
}
