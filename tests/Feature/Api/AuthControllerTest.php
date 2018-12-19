<?php

namespace Test\Feature\Api;

use Illuminate\Support\Str;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\UserResource;
use Illuminate\Foundation\Testing\WithFaker;
use Symfony\Component\HttpFoundation\Response;
use App\Repositories\Facades\UserRepo;

class AuthControllerTest extends TestCase
{
    use WithFaker;

    protected function setUp()
    {
        parent::setUp();
        $this->clearConfigurationCache()->installPassport();
    }

    /**
     * @group auth
     * @test Let's check that it can logged in an existed user
     */
    public function it_should_logged_in_user()
    {
        $user       =   factory(User::class)->create();
        $uri        =   route('api.auth.login');
        $credential =   [
            'email'     =>  $user->email,
            'password'  =>  '123456',
        ];
        $response   =   $this->postJson($uri, $credential);
        $response->assertSuccessful()
            ->assertJsonStructure(['access_token', 'token_type', 'expires_at']);

        $this->assertAuthenticated();
    }

    /**
     * @group auth
     * @test Let's check that it can reject a non-existed user
     */
    public function it_must_not_be_logged_in_non_existed_user()
    {
        $uri        =   route('api.auth.login');
        $credential =   [
            'email'     =>  $this->faker->safeEmail,
            'password'  =>  $this->faker->numerify('######'),
        ];
        $response   =   $this->postJson($uri, $credential);
        $response->assertStatus(Response::HTTP_NOT_FOUND)
            ->assertJsonValidationErrors(['email'])
            ->assertExactJson([
                'errors'    =>  [
                    'email' =>  [trans('auth.failed')]
                ]
            ]);
    }

    /**
     * @group auth
     * @test Let's check that is can return the authenticated user or not
     */
    public function it_should_return_an_authenticated_user()
    {
        $auth       =   $this->signInFromApi();
        $uri        =   route('api.auth.user');
        $response   =   $auth->getJson($uri);
        $resource   =   new UserResource(Auth::user());
        $response->assertSuccessful()->assertJson((array)$resource['data']);
    }

    /**
     * @group auth
     * @test Let's check that it can register a non existed user or not
     */
    public function it_should_register_a_non_existed_user()
    {
        $uri        =   route('api.auth.register');
        $password   =   $this->faker->numerify('######');
        $data       =   [
            'name'                  =>  $this->faker->name,
            'email'                 =>  $this->faker->safeEmail,
            'password'              =>  $password,
            'password_confirmation' =>  $password,
        ];

        $response   =   $this->setHeaders()->postJson($uri, $data);
        $response->assertStatus(Response::HTTP_CREATED)->assertJsonStructure();
    }

    /**
     * @group auth
     * @test Let's check that it can reject an existed user from registering twice or not
     */
    public function it_should_not_register_an_existed_user()
    {
        $this->signInFromApi();
        $password   =   $this->faker->numerify('######');
        $data       =   [
            'name'                  =>  $this->faker->name,
            'email'                 =>  Auth::user()->email,
            'password'              =>  $password,
            'password_confirmation' =>  $password,
        ];
        $uri        =   route('api.auth.register');
        $response   =   $this->setHeaders()->postJson($uri, $data);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonStructure(['message', 'errors']);
    }

    /**
     * @group auth
     * @test Let's check that it can active an existed user with correct token or not
     */
    public function it_should_active_a_non_activated_registered_user()
    {
        $auth       =   $this->signInFromApi();
        $user_id    =   Auth::id();
        $token      =   UserRepo::find($user_id)->activation_token;
        $uri        =   route('api.auth.activate', ['token' =>  $token]);
        $response   =   $auth->getJson($uri);
        $response->assertSuccessful()->assertJsonStructure(['message']);
        $this->assertTrue(UserRepo::find($user_id)->active);
    }

    /**
     * @group auth
     * @test Let's check if it can deny the activation request of a previously active user.
     */
    public function it_should_not_active_an_activated_user()
    {
        $auth           =   $this->signInFromApi();
        $user_id        =   Auth::id();
        $token          =   UserRepo::find($user_id)->activation_token;
        $uri            =   route('api.auth.activate', ['token' =>  $token]);
        $first_response =   $auth->getJson($uri);
        $first_response->assertSuccessful()->assertJsonStructure(['message']);
        $this->assertTrue(UserRepo::find($user_id)->active);

        $second_response    =   $auth->getJson($uri);
        $second_response->assertStatus(Response::HTTP_UNAUTHORIZED)->assertJsonStructure(['message']);
        $this->assertTrue(UserRepo::find($user_id)->active);
    }

    /**
     * @group auth
     * @test Let's check that it reject activation request with null or wrong token
     */
    public function it_should_not_active_a_user_with_null_token()
    {
        $auth           =   $this->signInFromApi();
        $user_id        =   Auth::id();

        $token          =   null;
        $uri            =   route('api.auth.activate', ['token' =>  $token]);
        $first_response =   $auth->getJson($uri);
        $first_response->assertStatus(Response::HTTP_NOT_FOUND)->assertJsonStructure(['message']);
        $this->assertFalse(UserRepo::find($user_id)->active);

        $token          =   Str::random(255);
        $uri            =   route('api.auth.activate', ['token' =>  $token]);
        $first_response =   $auth->getJson($uri);
        $first_response->assertStatus(Response::HTTP_UNAUTHORIZED)->assertJsonStructure(['message']);
        $this->assertFalse(UserRepo::find($user_id)->active);
    }
}
