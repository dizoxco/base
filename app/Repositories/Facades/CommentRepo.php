<?php

namespace App\Repositories\Facades;

use Illuminate\Support\Facades\Facade;
use App\Repositories\CommentRepository;

class CommentRepo extends Facade
{
    protected static function getFacadeAccessor()
    {
        return CommentRepository::class;
    }
}
