sdfsdfsdfsd
<ol>
    @forelse($cart as $variation)
        <li> {{ $variation->product->title }} </li>
        <li>
                <a href="{{ route('products.show', $variation->product->slug) }}">
                        مشاهده محصول
                </a>
        </li>
        <li>
            <a
                    style="text-decoration: none"
                    href="{{ route('cart.destroy', $variation->id) }}"
                    onclick="event.preventDefault();
                    document.getElementById('remove_product_from_cart').submit();"
            >
                حذف از سبد خرید
            </a>
            <form id="remove_product_from_cart" action="{{ route('cart.destroy', $variation->id) }}" method="post" style="display: none;">
                {{ csrf_field() }}
                {{ method_field('delete') }}}
            </form>
        </li>
    @empty
        You have no products in your cart yet!
    @endforelse
</ol>