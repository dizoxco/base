@extends('layout')
@section('content')
    <div class="flex flex-wrap container justify-center">
        @forelse($wishlist as $product)
            <div class="w-1/2 lg:w-1/4 p-3">
                @component('web.products.card', ['product' => $product])@endcomponent
            </div>
        @empty
            You have no product in your wish list yet!
        @endforelse
    </div>
    <br><br><br>
@endsection