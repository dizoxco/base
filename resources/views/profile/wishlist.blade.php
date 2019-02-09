<ol>
    @forelse($wishlist as $product)
        <li>
            <label > عنوان محصول</label>
            <label > {{ $product->title }}</label>
        </li>
        <li>
            <label > قیمت محصول</label>
            <label > @toman($product->price)</label>
        </li>
        <li>
            <a href="{{ route('products.show', $product->slug) }}"> مشاهده محصول </a>
        </li>
        <li>
            <a
                    style="text-decoration: none"
                    href="{{ route('wishlist.destroy', $product->slug) }}"
                    onclick="event.preventDefault();
                    document.getElementById('remove_product_from_wishlist').submit();"
            >
                حذف از علاقه مندی ها
            </a>
            <form id="remove_product_from_wishlist" action="{{ route('wishlist.destroy', $product->slug) }}" method="post" style="display: none;">
                {{ csrf_field() }}
                {{ method_field('delete') }}}
            </form>
        </li>
    @empty
        You have no product in your wish list yet!
    @endforelse
</ol>