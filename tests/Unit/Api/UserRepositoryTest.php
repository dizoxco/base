<?php

namespace Test\Unit\Api;

use Mockery;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Collection;
use App\Repositories\Facades\User as UserFacade;
use Illuminate\Foundation\Testing\WithFaker;

class UserRepositoryTest extends TestCase
{
    use WithFaker;

    public function tearDown()
    {
        //  resetting the container static variable to null.
        Mockery::close();
    }

    /**
     * @group UserRepository
     * @test let's check that it can retrieve a user via id or not
     */
    public function it_should_retrieve_the_user_via_id()
    {
        $expected_user  =   factory(User::class)->create();
        UserFacade::shouldReceive('find')
            ->once()
            ->with($expected_user->id)
            ->andReturn($expected_user);

        $actual_user    =   UserFacade::find($expected_user->id);
        $this->assertEquals($expected_user->toArray(), $actual_user->toArray());
    }

    /**
     * @group UserRepository
     * @test let's check that it can return null when user not exists or not
     */
    public function it_should_return_null_when_user_not_found()
    {
        $user_id    =   mt_rand(1,10);
        UserFacade::shouldReceive('find')
            ->once()
            ->with($user_id)
            ->andReturnNull();
        $user   =   UserFacade::find($user_id);
        $this->assertNull($user);
    }

    /**
     * @group UserRepository
     * @test let's check that it can retrieve a user via its email or not
     */
    public function it_should_retrieve_the_user_via_email()
    {
        $expected_user  =   factory(User::class)->create();
        UserFacade::shouldReceive('findByEmail')
            ->with($expected_user->email)
            ->andReturn($expected_user);

        $actual_user    =   UserFacade::findByEmail($expected_user->email);
        $this->assertEquals($expected_user->toArray(), $actual_user->toArray());
    }

    /**
     * @group UserRepository
     * @test let's check that it can return all users or not
     */
    public function it_should_return_all_users()
    {
        $number         =   mt_rand(2,10);
        $expected_users =   factory(User::class, $number)->create();
        UserFacade::shouldReceive('getAll')
            ->once()
            ->andReturn($expected_users);
        $actual_users   =   UserFacade::getAll();
        $this->assertEquals($expected_users->toArray(), $actual_users->toArray());
    }

    /**
     * @group UserRepository
     * @test let's check that it can create a user via given array or not
     */
    public function it_should_create_user_via_given_array()
    {
        $user   =   factory(User::class)->make();
        UserFacade::shouldReceive('create')
            ->with($user->toArray())
            ->andReturn($user);

        $created_user   =   UserFacade::create($user->getAttributes());
        $this->assertDatabaseHas('users', $created_user->getAttributes());
        $this->equalTo($user->toArray(), $created_user->toArray());
    }

    /**
     * @group UserRepository
     * @test let's check that it can return trashed users or not
     */
    public function it_should_return_trashed_users()
    {
        $number =   mt_rand(2,10);
        $expected_users =   factory(User::class, $number)->create();
        $expected_user  =   $expected_users->first();
        $expected_user->delete();
        UserFacade::shouldReceive('getTrashed')
            ->once()
            ->andReturn($expected_user);

        $actual_user   =   UserFacade::getTrashed();
        $this->assertEquals($actual_user->toArray(), $expected_user->toArray());
        $this->assertDatabaseMissing('users', $expected_user->toArray());
    }

    /**
     * @group UserRepository
     * @test let check that it can return null when user not exists
     */
    public function testGetAdmins()
    {

    }

    /**
     * @group UserRepository
     * @test let check that it can return null when user not exists
     */
    public function testFindBy()
    {
        $number =   mt_rand(2,10);
        $users  =   factory(User::class, $number)->create();
        $fields =   (new User())->getFillable();

        foreach ($fields as $field) {
            $fakes  =   [
                1   =>  $this->faker->numerify('####'),
                2   =>  $this->faker->numerify('####')
            ];
            foreach ($fakes as $index   =>  $fake) {
                $user   =   $users->where('id','=', $index)->first();
                $user->$field   =   $fake;
                $user->save();
            }

            $expected_users =   $users->whereIn('id', [1,2]);

            UserFacade::shouldReceive('getBy')
                ->once()
                ->with($field, $fake)
                ->andReturn($expected_users);
            foreach ($fakes as $index   =>  $fake) {
                $actual_users   =   UserFacade::getBy($field, $fake);
                $this->assertInstanceOf(Collection::class, $actual_users);
                $this->assertEquals($expected_users->toArray(), $actual_users->toArray());
            }

            foreach ($expected_users as $user) {
                $this->assertDatabaseHas('users', $user->toArray());
            }
        }
    }

    /**
     * @group UserRepository
     * @test let check that it can return null when user not exists
     */
    public function testSearchBy()
    {
        $user   =   factory(User::class)->create();
        UserFacade::shouldReceive('searchBy')
            ->with('name', $user->name)
            ->andReturn($user);
    }

    /**
     * @group UserRepository
     * @test let check that it can return null when user not exists
     */
    public function testUpdate()
    {
        /** @var User $user */
        $user       =   factory(User::class)->create();
        $user->setAttribute('name', $new_name);
        $user->syncChanges();
        $new_name   =   $this->faker->name;
        UserFacade::shouldReceive('update')
            ->with($user, $new_name)
            ->andReturn($user);
    }

    /**
     * @group UserRepository
     * @test let check that it can return null when user not exists
     */
    public function testDelete()
    {
        /** @var User $user */
        $user       =   factory(User::class)->create();
        UserFacade::shouldReceive('delete')
            ->with($user)
            ->andReturnTrue();

        $this->assertDatabaseMissing('users', $user);
    }
}
