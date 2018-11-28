<?php

namespace Test\Feature\Api;

use App\Enum\API;
use Tests\TestCase;
use App\Models\Post;
use App\Models\User;
use App\Models\Comment;
use Illuminate\Support\Collection;
use App\Http\Resources\User\UserResource;
use App\Http\Resources\User\UsersCollection;
use App\Http\Resources\Post\PostsCollection;
use Symfony\Component\HttpFoundation\Response;

class UserControllerTest extends TestCase
{

    /** @var self $auth_user */
    public $auth_user;

    /** @var User $correct_user */
    public $correct_user;

    /** @var User $wrong_user */
    public $wrong_user;

    protected function setUp()
    {
        parent::setUp();

        $this->clearConfigurationCache()->installPassport();
        $this->auth_user    =   $this->signInFromApi();
        $this->correct_user =   factory(User::class)->states('creation')->make();
        $this->wrong_user   =   factory(User::class)->states('creation')->make([
            'password_confirmation' =>  'not matched password'
        ]);
    }

    /**
     * @group users
     * @test Create 5 users and let check them exists in both response and db
     */
    public function it_should_return_users_index()
    {
        factory(User::class, 5)->create();
        $users      =   User::with(['posts', 'comments'])->paginate();
        $resource   =   new UsersCollection($users);
        $uri        =   route('api.users.index');

        //  Send Http Request
        $response   =   $this->auth_user->getJson($uri);

        //  Test Http
        $response
            ->assertSuccessful()
            ->assertHeader('Content-Type', API::APPLICATION_VND_API_JSON)
            ->assertJsonMissingExact(['errors'])
            ->assertJson((array) $resource['data']);


        //  Test Database
        foreach ($users as $user) {
            /** @var User $user */
            $conditions =   [
                'id'    =>  $user->id,
                'name'  =>  $user->name,
                'email' =>  $user->email,
            ];
            $this->assertDatabaseHas('users', $conditions);
        }
    }

    /**
     * @group users
     * @test let check it can make a user or not
     */
    public function it_should_create_new_users_on_post_request()
    {
        //  Data initializing
        $uri        =   route('api.users.store');
        $user       =   $this->correct_user;
        $resource   =   new UserResource($this->correct_user);

        //  Send a post http request
        $response   =   $this->auth_user->postJson($uri, $user->getAttributes());

        //  Test Http
        $response
            ->assertSuccessful()
            ->assertHeader('Content-Type', API::APPLICATION_VND_API_JSON)
            ->assertJsonMissingExact(['errors'])
            ->assertJson((array)$resource['data']);

        //  Test Database
        $conditions =   [
            'name'  =>  $user->name,
            'email' =>  $user->email,
        ];
        $this->assertDatabaseHas('users', $conditions);
    }

    /**
     * @group users
     * @test let check on bad request it reject request or not
     */
    public function it_should_reject_new_user_create_request()
    {
        $uri        =   route('api.users.store');
        $user       =   $this->wrong_user;
        $response   =   $this->auth_user->postJson($uri, $user->getAttributes());

        $response
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertHeader('Content-Type', API::APPLICATION_JSON)
            ->assertJsonValidationErrors(['password']);
    }

    /**
     * @group users
     * @test let check that a created user can viewed or not
     */
    public function it_should_show_users_info_after_creation()
    {
        $user       =   factory(User::class)->create();
        $resource   =   new UserResource($user);
        $uri        =   route('api.users.show', $user);
        $response   =   $this->auth_user->getJson($uri);
        $response
            ->assertSuccessful()
            ->assertHeader('Content-Type', API::APPLICATION_VND_API_JSON)
            ->assertJsonMissingExact(['errors'])
            ->assertJson((array)$resource['data']);
    }

    /**
     * @group users
     * @test let check it can create a user and then update it or not
     */
    public function it_should_create_and_update_a_user()
    {
        //  Data initializing
        $uri        =   route('api.users.store');
        $user       =   $this->correct_user;
        $resource   =   new UserResource($this->correct_user);

        //  Send a post http request
        $response   =   $this->auth_user->postJson($uri, $user->getAttributes());

        //  Test Http
        $response->assertSuccessful()
            ->assertHeader('content-type', API::APPLICATION_VND_API_JSON)
            ->assertJsonMissingExact(['errors'])
            ->assertJson((array)$resource['data']);

        //  Test Database
        $created_user   =   [
            'name'  =>  $user->name,
            'email' =>  $user->email,
        ];
        $this->assertDatabaseHas('users', $created_user);

        $uri        =   route(
            'api.users.update', [
                'UserFaker' =>  $response->json()['id']
            ]
        );
        $patched_user  =   [
            'name'  =>  'test',
            'email' =>  'm@n.com',
        ];
        $response   =   $this->auth_user->putJson($uri, $patched_user);
        $user       =   $user->setAttribute('name', $patched_user['name']);
        $user       =   $user->setAttribute('email', $patched_user['email']);
        $resource   =   new UserResource($user);
        $response
            ->assertSuccessful()
            ->assertHeader('Content-Type', API::APPLICATION_VND_API_JSON)
            ->assertJsonMissingExact(['errors'])
            ->assertJson((array)$resource['data']);

        $this->assertDatabaseHas('users', $patched_user);
    }

    /**
     * @group users
     * @test let check it can delete a user row entirely from db or not
     */
    public function it_should_destroy_a_user()
    {
        $user       =   factory(User::class)->create();
        $uri        =   route('api.users.destroy', ['UserFaker' =>  $user->id]);
        $response   =   $this->auth_user->deleteJson($uri);

        $response
            ->assertSuccessful()
            ->assertJsonMissingExact(['errors'])
            ->assertSeeText((string) true);

        $deleted_user   =   [
            'id'    =>  $user->id,
            'name'  =>  $user->name,
            'email' =>  $user->email,
        ];
        $this->assertDatabaseMissing('users', $deleted_user);
    }

    /**
     * @group users
     * @test let check that it can show posts that belongs to a user or not
     */
    public function it_should_show_posts_of_a_user()
    {
        /** @var User $user */
        $user       =   factory(User::class)->create();

        /** @var Collection $posts */
        $posts      =   factory(Post::class, 5)->make();
        $user->posts()->createMany($posts->toArray());

        $uri        =   route('api.users.posts', ['UserFaker' =>  $user->id]);
        $resource   =   new PostsCollection($user->posts);
        $response   =   $this->auth_user->getJson($uri);
        $response
            ->assertSuccessful()
            ->assertJson((array)$resource[0]['data']);
    }

    /**
     * @group users
     * @test let check that it can show comments that belongs to a user or not
     */
    public function it_should_show_comments_of_a_user()
    {
        /** @var User $user */
        $user   =   factory(User::class)->create();
        $posts  =   factory(Post::class, 5)->create(['user_id'  =>  $user->id]);
        //  assign posts to the user
        $user->posts->each(
            function (Post $post) {
                $post->comments()->createMany(
                    factory(Comment::class, 2)->make([
                        'user_id'   =>  $post->user_id,
                    ])->toArray()
                );
            }
        );

        $uri        =   route('api.users.comments', ['UserFaker' =>  $user->id]);
        $resource   =   new PostsCollection($user->posts);
        $response   =   $this->auth_user->getJson($uri);
        $response
            ->assertSuccessful()
            ->assertHeader('Content-Type', API::APPLICATION_VND_API_JSON)
            ->assertJsonMissingExact(['errors'])
            ->assertJson((array)$resource[0]['data']);
    }
}
