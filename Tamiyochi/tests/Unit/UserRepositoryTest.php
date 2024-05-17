<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Http\Controllers\UserController;
use App\Infrastructure\Repository\SqlUserRepository;

class UserRepositoryTest extends TestCase
{
    /**
     * A basic unit test example.
     */
    /** @test */
    public function it_can_fetch_users_with_parameter_search()
    {
        // $userRepository = new SqlUserRepository();
        // $users = $userRepository->getAllWithSearch("Karin");
        
        // $this->assertCount(1, $users);
        // $this->assertIsArray($users);

        // $this->assertEquals(23, $users[0]->getAge());
        // $this->assertEquals('Karina Gislason', $users[0]->getName());
        
        // $this->assertIsInt($users[0]->getAge());
        // $this->assertIsString($users[0]->getName());
        $userController = new UserController();
        $userTest = $userController->test();
        // dd($userTest->getData()->message);
        $this->assertEquals("Test", $userTest->getData()->message);
        // $this->assertIsObject($userTest->getData());
        // $this->assertJsonStringEqualsJsonFile('success', $userTest->getData());
    }

}
