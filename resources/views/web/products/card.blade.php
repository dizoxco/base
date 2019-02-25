<div class="relative rounded-lg bg-white h-full p-3 md:p-6 flex flex-col overflow-hidden" >
    @if($product->getMedia(enum('media.product.banner'))->isNotEmpty())
        <a class="no-underline" href="{{route('products.show', $product->slug)}}">
            <img src="{{$product->getFirstMedia(enum('media.product.banner'))->getFullUrl()}}" class="rounded-t">
        </a>
    @else
        <img src="https://dkstatics-public.digikala.com/digikala-products/4855241.jpg?x-oss-process=image/resize,m_lfit,h_600,w_600/quality,q_80" alt="">
    @endisset
    <div class="text-center flex flex-col h-full justify-between">
        <a class="no-underline mt-3" href="{{route('products.show', $product->slug)}}">
            <h3 class=" subheading"> {{ $product->title }}</h3>
        </a>
        {{-- <p>{{ $product->created_at->diffForHumans() }}</p> --}}
        <p class="text-center body-1 mt-3 ">@toman($product->price)</p>
    </div>
</div>