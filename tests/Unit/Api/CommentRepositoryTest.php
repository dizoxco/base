<?php

namespace Test\Unit\Api;

use Mockery;
use Tests\TestCase;
use App\Models\Comment;
use Illuminate\Support\Collection;
use App\Repositories\Facades\Comment as CommentRepo;
use Illuminate\Foundation\Testing\WithFaker;

class CommentRepositoryTest extends TestCase
{

    use WithFaker;

    public function tearDown()
    {
        //  resetting the container static variable to null.
        Mockery::close();
    }

    public function testFind()
    {

    }

    public function testFindByUser()
    {

    }

    public function testFindByCommentable()
    {

    }

    public function testGetBy()
    {

    }

    public function testGetAll()
    {

    }

    public function testGetTrashed()
    {

    }

    public function testCreate()
    {

    }

    public function testUpdate()
    {

    }

    public function testDelete()
    {

    }
}
