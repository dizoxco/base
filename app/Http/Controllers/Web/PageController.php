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
        $posts = PostRepo::getRecents(10);
        $products = ProductRepo::getRecents(10);
        $businesses = BusinessRepo::getRecents(10);

        return view('home', compact('posts', 'products', 'businesses'));
    }
}
