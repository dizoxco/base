<div class="relative rounded-lg bg-white h-full px-8 py-6" >
    @if($product->getMedia(enum('media.product.banner'))->isNotEmpty())
        <a class="no-underline" href="{{route('products.show', $product->slug)}}">
            <img src="{{$product->getFirstMedia(enum('media.product.banner'))->getFullUrl()}}" class="">
        </a>
    @else
        <img src="https://dkstatics-public.digikala.com/digikala-products/4855241.jpg?x-oss-process=image/resize,m_lfit,h_600,w_600/quality,q_80" alt="">
    @endisset
    <div class="text-center">
        <a class="no-underline" href="{{route('products.show', $product->slug)}}">
            <h3 class=" subheading"> {{ $product->title }}</h3>
        </a>
        <p class="text-center body-1 my-4">@toman($product->price)</p>
    </div>
</div>