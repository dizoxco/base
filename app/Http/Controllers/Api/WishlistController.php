<?php

namespace App\Http\Controllers\Api;

use App\Models\Wishlist;
use App\Http\Controllers\Controller;
use App\Http\Resources\EffectedRows;
use App\Http\Resources\WishlistCollection;
use App\Http\Requests\Wishlist\StoreWishlistRequest;

class WishlistController extends Controller
{
    public function index()
    {
        return new WishlistCollection(Wishlist::all());
    }

    public function store(StoreWishlistRequest $request)
    {
        auth_user()->wishlist()->create($request->all());

        return new WishlistCollection(Wishlist::all());
    }

    public function destroy(Wishlist $wishlist)
    {
        if ($wishlist->user->id === auth_user()->id) {
            return new EffectedRows($wishlist->delete());
        }
        // todo:response an unauthorized action
        abort(401);
    }
}
