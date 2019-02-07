<ol>
    @forelse($carts as $cart)
                <li> {{ $cart->variation->product->title }} </li>
                <li>
                        <a href="{{ route('products.show', $cart->variation->product->slug) }}">
                                مشاهده محصول
                        </a>
                </li>
    @empty
        You have no products in your cart yet!
    @endforelse
</ol>