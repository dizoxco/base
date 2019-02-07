<div class="relative rounded-lg bg-white shadow-lg h-full px-8 py-6" >
    @if($business->getMedia(enum('media.business.logo'))->isNotEmpty())
        <a class="no-underline" href="{{route('businesses.show', $business->slug)}}">
            <img src="{{$business->getFirstMedia(enum('media.business.logo'))->getFullUrl()}}" class="">
        </a>
    @else
        <img src="https://dkstatics-public.digikala.com/digikala-products/4855241.jpg?x-oss-process=image/resize,m_lfit,h_600,w_600/quality,q_80" alt="">
    @endisset
    <div class="text-center">
        <a class="no-underline" href="{{route('businesses.show', $business->slug)}}">
            <h3 class=" subheading"> {{ $business->brand }}</h3>
        </a>
        {{-- <p>{{ $product->created_at->diffForHumans() }}</p> --}}
        <p class="text-center body-1 my-4">{{ $business->city }}</p>
    </div>
</div>