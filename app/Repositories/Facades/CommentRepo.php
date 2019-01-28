<?php


namespace App\Repositories\Facades;


use App\Repositories\CommentRepository;
use Illuminate\Support\Facades\Facade;

class CommentRepo extends Facade
{
    protected static function getFacadeAccessor()
    {
        return CommentRepository::class;
    }
}