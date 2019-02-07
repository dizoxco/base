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
    @empty
        You have no product in your wish list yet!
    @endforelse
</ol>