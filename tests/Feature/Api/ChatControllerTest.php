<?php

namespace Test\Feature\Api;

use Tests\TestCase;
use App\Models\Chat;
use App\Models\User;
use App\Models\Comment;
use Illuminate\Http\UploadedFile;
use Illuminate\Foundation\Testing\WithFaker;
use Symfony\Component\HttpFoundation\Response;

class ChatControllerTest extends TestCase
{
    use WithFaker;

    protected $providedData = [];

    protected function signInFromWeb()
    {
        return $this->clearConfigurationCache()->installPassport()->signInFromApi();
    }

    protected function routeIndex()
    {
        return route('api.user.chats.index');
    }

    protected function routeStore()
    {
        return route('api.user.chats.store');
    }

    protected function routeShow($chat)
    {
        return route('api.user.chats.show', ['chat' => $chat]);
    }

    protected function routeUpdate($chat)
    {
        return route('api.user.chats.update', ['chat' => $chat]);
    }

    protected function dataProvider()
    {
        $user = User::inRandomOrder()->first(['id']);
        $userId = $user !== null ? $user->id : mt_rand(1, mt_getrandmax());
        $size = 1024 * 10; // 10 MegaByte
        $data = [
            'user_id'   =>  $userId,
            'body'      =>  $this->faker()->sentences(3, true),
            'file'      =>  UploadedFile::fake()->create($this->faker->name, $size),
        ];

        $this->providedData = $data;

        return $this;
    }

    protected function getData()
    {
        return $this->providedData;
    }

    protected function withPutMethod()
    {
        $this->providedData['_method'] = 'put';

        return $this;
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
     * @group chat.index
     * @test Let's check that when the database is empty, the conversation should not be returned.
     */
    public function it_should_not_returned_anything_when_the_user_does_not_have_a_chat()
    {
        //  When the database is completely empty.
        $this->signInFromWeb()->assertAuthHasNoChat();

        //  When the database contains the chat.
        $users = factory(User::class, 5)->create();
        $chats = factory(Chat::class, 10)->create();

        $chats->each(
            function (Chat $chat) use ($users) {
                $chat->users()->attach($users->random()->id);
                $chat->users()->attach($users->random()->id);
            }
        );

        $this->assertAuthHasNoChat();
    }

    /**
     * @group chat.index
     * @test Let's check that it can return the actual list of a single user chat
     */
    public function it_must_not_return_conversations_owned_by_another_user()
    {
        $this->signInFromWeb();
        $user = auth_user();
        $chat = $user->chats()->create(['type'  =>  enum('chat.type.chat')]);

        $another_user = factory(User::class)->create();
        $chat->users()->attach($another_user->id);

        $this->assertAuthHasChat();

        $users = factory(User::class, 5)->create();
        $chats = factory(Chat::class, 10)->create();
        $chats->each(
            function (Chat $chat) use ($users) {
                $chat->users()->attach($users->random()->id);
                $chat->users()->attach($users->random()->id);
            }
        );

        $this->assertAuthHasChat();
    }

    /**
     * @group chat.index
     * @group chat.show
     * @test Let's check that it can reject non authenticated user for visits chat index or not
     */
    public function non_authenticated_user_can_not_see_any_chat()
    {
        $response = $this->getJson($this->routeIndex());
        $response->assertStatus(Response::HTTP_UNAUTHORIZED)
            ->assertJson(['message' =>  'Unauthenticated.']);

        $chat = factory(Chat::class)->create();
        $response = $this->getJson($this->routeShow($chat->id), $this->dataProvider()->getData());
        $response->assertStatus(Response::HTTP_UNAUTHORIZED)
            ->assertJson(['message' => 'Unauthenticated.']);
    }

    /**
     * @group chat.store
     * @test Let's check that it can reject non authenticated user for store new chat or not
     */
    public function non_authenticated_user_can_not_store_chat()
    {
        $response = $this->postJson($this->routeStore(), $this->dataProvider()->getData());
        $response->assertStatus(Response::HTTP_UNAUTHORIZED)
            ->assertJson(['message' => 'Unauthenticated.']);
    }

    /**
     * @group chat.update
     * @test Let's check that it can reject non authenticated user for update a chat or not
     */
    public function non_authenticated_user_can_not_update_chat()
    {
        $chat = factory(Chat::class)->create();
        $response = $this->postJson(
            $this->routeUpdate($chat),
            $this->dataProvider()->withPutMethod()->getData()
        );
        $response->assertStatus(Response::HTTP_UNAUTHORIZED)
            ->assertJson(['message' => 'Unauthenticated.']);
    }

    /**
     * @group chats.store
     * @test Let's check that it can reject a store request without user_id or not
     */
    public function the_user_can_not_store_a_chat_without_userId()
    {
        $garbage = 'user_id';
        $data = $this->dataProvider()->without($garbage);
        $response = $this->signInFromWeb()->postJson($this->routeStore(), $data);
        $this->assertValidationFails($response, $garbage);
    }

    /**
     * @group chats.store
     * @test Let's check that it can reject a store request with user_id of invalid type
     */
    public function the_user_can_not_store_a_chat_with_userId_type_other_than_integer()
    {
        $this->signInFromWeb();

        $garbage = 'user_id';
        $data = $this->dataProvider()->without($garbage);

        $invalidUserIdTypes = [null, true, false, [], str_random()];
        foreach ($invalidUserIdTypes as $userIdType) {
            $data['user_id'] = $userIdType;
            $response = $this->postJson($this->routeStore(), $data);
            $this->assertValidationFails($response, $garbage);
        }
    }

    /**
     * @group chats.store
     * @test Let's check that it can reject a store request with user_id that not exists
     */
    public function the_user_can_not_store_a_chat_with_userId_that_not_exists()
    {
        $garbage = 'user_id';
        $nonExistsUserId = random_int(1, mt_getrandmax());
        while (User::find($nonExistsUserId) !== null) {
            $nonExistsUserId++;
        }
        $data = $this->dataProvider()->without($garbage);
        $data['user_id'] = $nonExistsUserId;

        $response = $this->signInFromWeb()->postJson($this->routeStore(), $data);
        $this->assertValidationFails($response, $garbage);
    }

    /**
     * @group chats.store
     * @test Let's check that it can reject a store request with user_id equal to auth_user()->id
     */
    public function the_user_can_not_store_a_chat_with_userId_of_himself()
    {
        $this->signInFromWeb();
        $garbage = 'user_id';
        $data = $this->dataProvider()->without($garbage);
        $data['user_id'] = auth_user()->id;
        $response = $this->postJson($this->routeStore(), $data);
        $this->assertValidationFails($response, $garbage);
    }

    /**
     * @group chats.store
     * @test Let's check that it can store a request with just user_id and body
     */
    public function the_user_can_store_a_chat_with_body_and_without_file()
    {
        $anotherUser = factory(User::class)->create();
        $data = $this->dataProvider()->without('user_id', 'file');
        $data['user_id'] = $anotherUser->id;
        $response = $this->signInFromWeb()->postJson($this->routeStore(), $data);
        $response->assertSuccessful()
            ->assertHeader('Content-Type', enum('system.response.json'))
            ->assertJsonStructure([
                'data' => ['id', 'type', 'attributes', 'relations'],
            ]);
    }

    /**
     * @group chats.store
     * @test Let's check that it can reject a request with invalid body type
     */
    public function the_user_can_not_store_a_chat_with_body_type_other_than_string()
    {
        $this->signInFromWeb();

        $garbage = 'body';
        $data = $this->dataProvider()->without($garbage);

        $invalidBodyTypes = [null, true, false, [], mt_rand(0, mt_getrandmax())];
        foreach ($invalidBodyTypes as $bodyTypes) {
            $data['body'] = $bodyTypes;
            $response = $this->postJson($this->routeStore(), $data);
            $this->assertValidationFails($response, $garbage);
        }
    }

    /**
     * @group chats.store
     * @test Let's check that it can store a request with just user_id and file
     */
    public function the_user_can_store_a_chat_with_file_and_without_body()
    {
        $anotherUser = factory(User::class)->create();
        $data = $this->dataProvider()->without('user_id', 'body');
        $data['user_id'] = $anotherUser->id;
        $response = $this->signInFromWeb()->postJson($this->routeStore(), $data);
        $response->assertSuccessful()
            ->assertHeader('Content-Type', enum('system.response.json'))
            ->assertJsonStructure([
                'data' => ['id', 'type', 'attributes', 'relations'],
            ]);
    }

    /**
     * @group chats.store
     * @test Let's check that it can reject a request with invalid file type
     */
    public function the_user_can_not_store_a_chat_with_file_type_other_than_uploadedFile()
    {
        $this->signInFromWeb();

        $garbage = 'file';
        $data = $this->dataProvider()->without($garbage);

        $invalidBodyTypes = [null, true, false, [], random_int(0, mt_getrandmax())];
        foreach ($invalidBodyTypes as $bodyTypes) {
            $data['file'] = $bodyTypes;
            $response = $this->postJson($this->routeStore(), $data);
            $this->assertValidationFails($response, $garbage);
        }
    }

    /**
     * @group chats.store
     * @test Let's check that it can reject a store request with file and body or not
     */
    public function the_user_can_not_store_a_chat_without_body_and_file()
    {
        $this->signInFromWeb();
        $data['user_id'] = auth_user()->id;
        $response = $this->postJson($this->routeStore(), $data);
        $this->assertValidationFails($response, ['body', 'file']);
    }

    /**
     * @group chats.store
     * @test Let's check that it can store a request with both body and file
     */
    public function the_user_can_store_a_chat_with_both_file_and_body()
    {
        $anotherUser = factory(User::class)->create();
        $data = $this->dataProvider()->without('user_id');
        $data['user_id'] = $anotherUser->id;
        $response = $this->signInFromWeb()->postJson($this->routeStore(), $data);
        $response->assertSuccessful()
            ->assertHeader('Content-Type', enum('system.response.json'))
            ->assertJsonStructure([
                'data' => ['id', 'type', 'attributes', 'relations'],
            ]);
    }

    /**
     * @group chats.show
     * @test Let's check that it can response proper message or not when there is no chat exists
     */
    public function it_should_be_returned_http_not_found_when_there_is_no_chat_on_store()
    {
        $this->signInFromWeb();
        $chat = random_int(1, mt_getrandmax());
        $response = $this->getJson($this->routeShow($chat));
        $response->assertStatus(Response::HTTP_NOT_FOUND)
            ->assertJsonStructure(['errors', 'message']);
    }

    /**
     * @group chats.show
     * @test Let's check that it can response proper message or not when there is chats exists
     */
    public function it_should_be_returned_chat_resource_when_there_is_chats_exists()
    {
        $this->signInFromWeb();
        $chats = factory(Chat::class, 5)->create()->each(
            function (Chat $chat) {
                $chat->users()->attach(auth_user()->id);
                $chat->users()->attach(factory(User::class)->create()->id);
                $comment = factory(Comment::class)->make(['user_id' => auth_user()->id])->toArray();
                $comment = $chat->comments()->create($comment);
                $media = UploadedFile::fake()->create($this->faker->name, 1024 * 10);
                $comment->addMedia($media);
            }
        );

        foreach ($chats as $chat) {
            $response = $this->getJson($this->routeShow($chat));
            $response->assertSuccessful()
                ->assertJsonStructure([
                    'data'   =>  [
                        'id', 'type', 'attributes', 'relations',
                    ],
                ]);
        }
    }

    /**
     * @group chats.update
     * @test Let's check that it reject update requests for chats that not exists
     */
    public function it_should_be_returned_http_not_found_when_there_is_no_chat_on_update()
    {
        $this->signInFromWeb();
        $chat = random_int(1, mt_getrandmax());
        $data = $this->dataProvider()->withPutMethod()->getData();
        $response = $this->postJson($this->routeUpdate($chat), $data);
        $response->assertStatus(Response::HTTP_NOT_FOUND)
            ->assertJsonStructure(['message', 'errors']);
    }

    /**
     * @group chats.update
     * @test Let's check that it can store a request with just user_id and body
     */
    public function the_user_can_update_a_chat_with_body_and_without_file()
    {
        $data = $this->dataProvider()->withPutMethod()->without('user_id', 'file');
        $chat = factory(Chat::class)->create();
        $response = $this->signInFromWeb()->postJson($this->routeUpdate($chat), $data);
        $response->assertSuccessful()
            ->assertHeader('Content-Type', enum('system.response.json'))
            ->assertJsonStructure([
                'data' => ['id', 'type', 'attributes', 'relations'],
            ]);
        $this->assertDatabaseHas('comments', [
            'user_id'   =>  auth_user()->id,
            'body'      =>  $data['body'],
        ]);
    }

    /**
     * @group chats.update
     * @test Let's check that it can reject a request with invalid body type
     */
    public function the_user_can_not_update_a_chat_with_body_type_other_than_string()
    {
        $this->signInFromWeb();

        $garbage = 'body';
        $data = $this->dataProvider()->withPutMethod()->without($garbage);
        $chat = factory(Chat::class)->create();

        $invalidBodyTypes = [null, true, false, [], mt_rand(0, mt_getrandmax())];
        foreach ($invalidBodyTypes as $bodyTypes) {
            $data['body'] = $bodyTypes;
            $response = $this->postJson($this->routeUpdate($chat), $data);
            $this->assertValidationFails($response, $garbage);
        }
    }

    /**
     * @group chats.update
     * @test Let's check that it can store a request with just user_id and file
     */
    public function the_user_can_update_a_chat_with_file_and_without_body()
    {
        $data = $this->dataProvider()->withPutMethod()->without('user_id', 'body');
        $chat = factory(Chat::class)->create();
        $response = $this->signInFromWeb()->postJson($this->routeUpdate($chat), $data);
        $response->assertSuccessful()
            ->assertHeader('Content-Type', enum('system.response.json'))
            ->assertJsonStructure([
                'data' => ['id', 'type', 'attributes', 'relations'],
            ]);
        $this->assertDatabaseHas('comments', [
            'user_id'   =>  auth_user()->id,
            'body'      =>  null,
        ]);
    }

    /**
     * @group chats.update
     * @test Let's check that it can reject a request with invalid file type
     */
    public function the_user_can_not_update_a_chat_with_file_type_other_than_uploadedFile()
    {
        $this->signInFromWeb();

        $garbage = 'file';
        $data = $this->dataProvider()->withPutMethod()->without($garbage);
        $chat = factory(Chat::class)->create();

        $invalidBodyTypes = [null, true, false, [], random_int(0, mt_getrandmax())];
        foreach ($invalidBodyTypes as $bodyTypes) {
            $data['file'] = $bodyTypes;
            $response = $this->postJson($this->routeUpdate($chat), $data);
            $this->assertValidationFails($response, $garbage);
        }
    }

    /**
     * @group chats.update
     * @test Let's check that it can reject a store request with file and body or not
     */
    public function the_user_can_not_update_a_chat_without_body_and_file()
    {
        $this->signInFromWeb();

        $chat = factory(Chat::class)->create();
        $response = $this->postJson(
            $this->routeUpdate($chat),
            ['_method'  =>  'PUT']
        );

        $this->assertValidationFails($response, ['body', 'file']);
    }

    /**
     * @group chats.update
     * @test Let's check that it can store a request with both body and file
     */
    public function the_user_can_update_a_chat_with_both_file_and_body()
    {
        $this->signInFromWeb();
        $data = $this->dataProvider()->withPutMethod()->getData();
        $chat = factory(Chat::class)->create();
        $response = $this->postJson($this->routeUpdate($chat), $data);
        $response->assertSuccessful()
            ->assertHeader('Content-Type', enum('system.response.json'))
            ->assertJsonStructure([
                'data' => ['id', 'type', 'attributes', 'relations'],
            ]);
        $this->assertDatabaseHas('comments', [
            'user_id'   =>  auth_user()->id,
            'body'      =>  $data['body'],
        ]);
    }

    private function assertAuthHasNoChat(): void
    {
        $response = $this->getJson($this->routeIndex());
        $response
            ->assertSuccessful()
            ->assertHeader('Content-Type', enum('system.response.json'))
            ->assertJson(['data' => []]);
    }

    private function assertAuthHasChat(): void
    {
        $response = $this->getJson($this->routeIndex());
        $response
            ->assertSuccessful()
            ->assertHeader('Content-Type', enum('system.response.json'))
            ->assertJsonStructure([
                'data' => [
                    ['id', 'type', 'attributes', 'relations'],
                ],
            ]);
    }

    public function assertValidationFails($response, $without): void
    {
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertHeader('Content-Type', enum('system.response.json'))
            ->assertJsonStructure(['message', 'errors'])
            ->assertJsonValidationErrors($without);
    }
}
