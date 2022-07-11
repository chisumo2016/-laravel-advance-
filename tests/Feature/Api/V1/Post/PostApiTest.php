<?php

namespace Tests\Feature\Api\V1\Post;

use App\Events\Models\Post\PostCreated;
use App\Events\Models\Post\PostDeleted;
use App\Events\Models\Post\PostUpdated;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

class PostApiTest extends TestCase
{
       use RefreshDatabase;
    public function  setUp(): void
    {
        parent::setUp();
        /** creating a dummy user and pass*/
        $user = User::factory()->create();
        $this->actingAs($user);
    }


    public function test_index()
    {
        /** Load data in database */
        $posts = Post::factory(10)->create();
        $postIds = $posts->map(fn($post) =>$post->id);

        /** Call http index endpoint */
        $response = $this->json('get','/api/v1/test/posts');

        /** Assert Status */
        $response->assertStatus(200);

        /** Verify records */
        $data = $response->json('data');
        collect($data)->each(fn($post) => $this->assertTrue(in_array($post['id'], $postIds->toArray())));

        //dump($data);
    }

    public function test_show()
    {
        $dummyPost = Post::factory()->create();

        $response = $this->json('get','/api/v1/test/posts/' . $dummyPost->id);

        $result = $response->assertStatus(200)->json('data');

        $this->assertEquals(data_get($result, 'id'), $dummyPost->id,'Response ID not the same ass model id');

    }

    public function test_create()
    {
        Event::fake();
        $dummyPost = Post::factory()->make();

        $dummyUser = User::factory()->create();

        $response = $this->json('post','/api/v1/test/posts', array_merge($dummyPost->toArray(), ['user_ids' =>[$dummyUser->id]]));
        //$response = $this->json('post','/api/v1/test/posts', $dummyPost->toArray());

        $result = $response->assertStatus(201)->json('data');

        Event::assertDispatched(PostCreated::class);

        //compare response with dummy model

        $result = collect($result)->only(array_keys($dummyPost->getAttributes()));

        $result->each(function ($value, $field) use ($dummyPost){
            $this->assertSame(data_get($dummyPost, $field), $value ,  'Fillable is not the same' );
        });

    }

    public function test_update()
    {
        $dummyPost = Post::factory()->create();
        $dummyPost2 = Post::factory()->make();

        Event::fake();

        $fillables = collect((new Post())->getFillable());

        $fillables->each(function ($toUpdate) use ($dummyPost, $dummyPost2){
            $response = $this->json('patch','/api/v1/test/posts/' . $dummyPost->id,[
                /** Field to update */
                $toUpdate => data_get($dummyPost2, $toUpdate),
            ]);

            $result = $response->assertStatus(200)->json('data');

            Event::assertDispatched(PostUpdated::class);

            $this->assertSame(data_get($dummyPost2, $toUpdate), data_get($dummyPost->refresh(),$toUpdate) ,  'Failed to update our model' );
        });


    }

    public function test_delete()
    {
        Event::fake();
        $dummyPost = Post::factory()->create();

        $response = $this->json('delete','/api/v1/test/posts/' . $dummyPost->id);

        $result = $response->assertStatus(200);

        Event::assertDispatched(PostDeleted::class);

        $this->expectException(ModelNotFoundException::class);
        Post::query()->findOrFail($dummyPost->id);
    }
}
