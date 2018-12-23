<?php

namespace Test\Feature\Api;

use App\Events\User\UserStoreEvent;
use App\Models\User;
use App\Repositories\Facades\UserRepo;
use Event;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class AuthControllerTest extends TestCase
{
    use WithFaker;

    protected   $providedData;

    protected function setUp()
    {
        parent::setUp(); // TODO: Change the autogenerated stub
        Event::fake();
    }

    protected function login()
    {
        return $this->clearConfigurationCache()->installPassport()->signInFromApi();
    }

    protected function routeLogin()
    {
        return route('api.auth.login');
    }

    protected function routeRegister()
    {
        return route('api.auth.register');
    }

    protected function routeLogOut()
    {
        return route('api.auth.logout');
    }

    protected function dataProvider()
    {
        $password = str_random(6);
        $this->providedData =   [
            'name'                  =>  $this->faker()->firstName,
            'email'                 =>  $this->faker()->email,
            'password'              =>  $password,
            'password_confirmation' =>  $password,
        ];
        return $this;
    }

    protected function getData()
    {
        return $this->providedData;
    }

    protected function without(...$without)
    {
        if (count(func_get_args()) > 0) {
            foreach ($without as $key) {
                unset($this->providedData[$key]);
            }
        }

        return $this->providedData;
    }

    /**
     * @group auth.login
     * @test Let's check that it can logged in an existed user
     */
    public function it_should_the_existing_user_can_login()
    {
        $this->clearConfigurationCache()->installPassport();

        $user       =   factory(User::class)->create();
        $credential =   [
            'email'     =>  $user->email,
            'password'  =>  '123456',
        ];
        $response   =   $this->postJson($this->routeLogin(), $credential);
        $response->assertSuccessful()
            ->assertJsonStructure(['access_token', 'token_type', 'expires_at']);

        $this->assertAuthenticated();
    }
    
    /**
     * @group auth.login
     * @test Let's check that it can reject a non-existed user from logging in
     */
    public function it_must_invalid_user_can_not_enter()
    {
        $credential =   [
            'email'     =>  $this->faker->safeEmail,
            'password'  =>  $this->faker->numerify('######'),
        ];
        $response   =   $this->postJson($this->routeLogin(), $credential);
        $response->assertStatus(Response::HTTP_NOT_FOUND)
            ->assertJsonValidationErrors(['email'])
            ->assertExactJson([
                'errors'    =>  [
                    'email' =>  [trans('auth.failed')]
                ]
            ]);
    }

    /**
     * @group auth.logout
     * Let's check that it can logged out an authenticated user
     */
    public function it_should_the_logged_in_user_can_exit()
    {
        // fixme: the logout in real world works but in the tests not work
        $response   =   $this->login()->getJson($this->routeLogOut());
        $response->assertJsonStructure(['errors']);
        $this->assertGuest('api');
        $response   =   $this->withMiddleware()->getJson(route('api.users.index'));
        $response->assertJsonStructure(['message'   =>   'Unauthenticated']);
    }

    /**
     * @group auth.logout
     * @test Let's check if the user who is not logged in can go out or not?
     */
    public function it_must_the_user_who_is_not_logged_in_can_not_log_out()
    {
        $headers    =   [
            'Accept'            =>  enum('system.response.json'),
            'Content-Type'      =>  enum('system.response.json'),
            'X-Requested-With'  =>  enum('system.request.xhr')
        ];

        $response   =   $this->withHeaders($headers)->getJson($this->routeLogOut());
        $response->assertJsonStructure(['message'])
            ->assertHeader('Content-Type', enum('system.response.json'))
            ->assertHeader('X-RateLimit-Limit', 60)
            ->assertHeader('X-RateLimit-Remaining', 59)
            ->assertStatus(401);
    }

    /**
     * @group auth.register
     * @test Let's check it can reject a register request without name or not
     */
    public function the_user_can_not_register_without_a_name()
    {
        $response   =   $this->postJson(
            $this->routeRegister(),
            $this->dataProvider()->without('name')
        );
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonStructure(['message', 'errors'])
            ->assertJsonValidationErrors('name');
        
        Event::assertNotDispatched(UserStoreEvent::class);
    }

    /**
     * @group auth.register
     * @test Let's check it can reject a register request without name or not
     */
    public function the_user_can_not_register_without_a_email()
    {
        $response   =   $this->postJson(
            $this->routeRegister(),
            $this->dataProvider()->without('email')
        );
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonStructure(['message', 'errors'])
            ->assertJsonValidationErrors('email');
        
        Event::assertNotDispatched(UserStoreEvent::class);
    }

    /**
     * @group auth.register
     * @test Let's check it can reject a register request without name or not
     */
    public function the_user_can_not_register_with_an_invalid_email()
    {
        $data           =   $this->dataProvider()->without('email');
        $data['email']  =   str_random();
        $response   =   $this->postJson($this->routeRegister(), $data);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonStructure(['message', 'errors'])
            ->assertJsonValidationErrors('email');
        
        Event::assertNotDispatched(UserStoreEvent::class);
    }

    /**
     * @group auth.register
     * @test Let's check it can reject a register request without name or not
     */
    public function the_user_can_not_register_with_a_duplicate_email()
    {
        $user           =   factory(User::class)->create();
        $data           =   $this->dataProvider()->without('email');
        $data['email']  =   $user->email;
        $response = $this->postJson($this->routeRegister(), $data);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonStructure(['message', 'errors'])
            ->assertJsonValidationErrors('email');
        
        Event::assertNotDispatched(UserStoreEvent::class);
    }

    /**
     * @group auth.register
     * @test Let's check it can reject a register request without name or not
     */
    public function the_user_can_not_register_without_a_password()
    {
        $response = $this->postJson(
            $this->routeRegister(),
            $this->dataProvider()->without('password')
        );
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonStructure(['message', 'errors'])
            ->assertJsonValidationErrors('password');
        
        Event::assertNotDispatched(UserStoreEvent::class);
    }

    /**
     * @group auth.register
     * @test Let's check it can reject a register request without name or not
     */
    public function the_user_can_not_register_with_none_string_password()
    {
        $data           =   $this->dataProvider()->without('password');
        $nonStringValue =   [null , true, false, []];
        foreach ($nonStringValue as $value) {
            $data['password']   =   $value;
            $response = $this->postJson($this->routeRegister(), $data);
            $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
                ->assertJsonStructure(['message', 'errors'])
                ->assertJsonValidationErrors('password');
            
            Event::assertNotDispatched(UserStoreEvent::class);
        }
    }

    /**
     * @group auth.register
     * @test Let's check it can reject a register request without name or not
     */
    public function the_user_can_not_register_with_a_less_than_six_character_password()
    {
        $data       =   $this->dataProvider()->without('password');
        
        for ($i = 0; $i < 6; $i++) {
            $data['password']   =   str_random($i);
            $response           =   $this->postJson($this->routeRegister(), $data);
            $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
                ->assertJsonStructure(['message', 'errors'])
                ->assertJsonValidationErrors('password');
            Event::assertNotDispatched(UserStoreEvent::class);
        }
    }

    /**
     * @group auth.register
     * @test Let's check it can reject a register request without name or not
     */
    public function the_user_can_not_register_without_password_confirmation()
    {
        $response = $this->postJson(
            $this->routeRegister(),
            $this->dataProvider()->without('password_confirmation')
        );
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonStructure(['message', 'errors'])
            ->assertJsonValidationErrors('password');
        Event::assertNotDispatched(UserStoreEvent::class);
    }


    /**
     * @group auth.register
     * @test Let's check that it can register a non existed user or not
     */
    public function it_should_register_a_non_existed_user()
    {
        
        $data = $this->dataProvider()->getData();
        $response   =   $this->postJson($this->routeRegister(),$data);
        $response->assertStatus(Response::HTTP_CREATED)
            ->assertJson([
                'message'   =>  trans('auth.register')
            ]);

        $this->assertDatabaseHas('users', [
            'name'  =>  $data['name'],
            'email' =>  $data['email'],
        ]);

        $user   =   User::first();
        $this->assertNotNull($user->activation_token);
        Event::assertDispatched(UserStoreEvent::class, function ($event) use ($user) {
           return $event->user->is($user);
        });
    }

    /**
     * @group auth.activate
     * @test Let's check that it can active an existed user with correct token or not
     */
    public function it_should_active_a_non_activated_registered_user()
    {
        $user       =   factory(User::class)->create();
        $uri        =   route('api.auth.activate', ['token' =>  $user->activation_token]);
        $response   =   $this->getJson($uri);
        $response->assertSuccessful()->assertJsonStructure(['message']);
        $this->assertTrue(UserRepo::isActive($user->id));
    }

    /**
     * @group auth.activate
     * @test Let's check if it can deny the activation request of a previously active user.
     */
    public function an_active_user_should_not_be_reactivated()
    {
        $user       =   factory(User::class)->create();
        $uri        =   route('api.auth.activate', ['token' =>  $user->activation_token]);
        $response   =   $this->getJson($uri);
        $response->assertSuccessful()->assertJson(['message'   =>  trans('auth.activated')]);
        $this->assertTrue(UserRepo::isActive($user));

        $second_response    =   $this->getJson($uri);
        $second_response->assertStatus(Response::HTTP_BAD_REQUEST)->assertJson([
            'message'   =>  trans('auth.token_expired')
        ]);
        $this->assertTrue(UserRepo::isActive($user));
    }

    /**
     * @group auth.activate
     * @test Let's check that it reject activation request with null or wrong token
     */
    public function it_should_not_active_a_user_with_null_or_invalid_token()
    {
        $auth       =   $this->login();
        $user_id    =   Auth::id();
        $tokens     =   [null, true, false, str_random(32)];
        foreach ($tokens as $token) {
            $uri        =   route('api.auth.activate', ['token' =>  $token]);
            $response   =   $auth->getJson($uri);
            if (empty($token)) {
                $response->assertStatus(Response::HTTP_NOT_FOUND)
                    ->assertJson([
                        'message'   =>  trans('http.not_found')
                    ]);
            } else {
                $response->assertStatus(Response::HTTP_BAD_REQUEST)
                    ->assertJson([
                        'message'   =>  trans('auth.token_expired')
                    ]);
            }
        }
        $this->assertFalse(UserRepo::isActive($user_id));
    }
}
