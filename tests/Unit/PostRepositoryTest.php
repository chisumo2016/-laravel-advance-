<?php

namespace Tests\Unit;

use App\Exceptions\GeneralJsonException;
use App\Models\Post;
use App\Repositories\PostRepository;
use Tests\TestCase;

class PostRepositoryTest extends  TestCase
{
    public function test_create()
    {
        $repository = $this->app->make(PostRepository::class);

        $payload =  [
            'title' => "tanzania",
            'body' => []
        ];

        $result = $repository->create($payload);

        $this->assertSame($payload['title'], $result->title, 'Post created does not have the same title' );
    }

    public function test_update()
    {
        $repository = $this->app->make(PostRepository::class);

        $dummyPost = Post::factory(1)->create()[0];

        $payload =  [
            'title' => "3dcccccccccc",
            'body' => []
        ];

        //compare
        $updatePost = $repository->update($dummyPost, $payload);

        $this->assertSame($payload['title'], $updatePost->title,'Post updated does not have the same post title');


    }

    public function test_delete()
    {

       $repository = $this->app->make(PostRepository::class);
       $dummy =  Post::factory(1)->create()->first();

       $deletedPost = $repository->forceDelete($dummy);

       $found = Post::query()->find($dummy->id);

       $this->assertSame(null, $found, 'Post is not deleted');
    }

    public function test_delete_will_throw_exception_when_delete_post_that_doesnt_exist()
    {
        $repository = $this->app->make(PostRepository::class);
        $dummy =  Post::factory(1)->make()->first();

        $this->expectException(GeneralJsonException::class);

        $deletedPost = $repository->forceDelete($dummy);

    }
}
