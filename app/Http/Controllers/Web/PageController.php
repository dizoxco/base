<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Repositories\Facades\PostRepo;
use App\Repositories\Facades\ProductRepo;
use App\Repositories\Facades\BusinessRepo;

class PageController extends Controller
{
    public function home()
    {
        $posts = PostRepo::getRecent(10);
        $products = ProductRepo::getRecent(10);
        $businesses = BusinessRepo::getRecent(10);

        return view('home', compact('posts', 'products', 'businesses'));
    }
}
