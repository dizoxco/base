<div class="relative rounded-lg bg-white h-full p-3 md:p-6 flex flex-col overflow-hidden" >
    @if($business->getMedia(enum('media.business.logo'))->isNotEmpty())
        <a class="no-underline" href="{{route('businesses.show', $business->slug)}}">
            <img src="{{$business->getFirstMedia(enum('media.business.logo'))->getFullUrl()}}" class="rounded-t">
        </a>
    @else
        <img src="https://dkstatics-public.digikala.com/digikala-products/4855241.jpg?x-oss-process=image/resize,m_lfit,h_600,w_600/quality,q_80" alt="">
    @endisset
    <div class="text-center flex flex-col h-full justify-between">
        <a class="no-underline mt-3" href="{{route('businesses.show', $business->slug)}}">
            <h3 class=" subheading"> {{ $business->brand }}</h3>
        </a>
        <p class="text-center body-1 mt-3">{{ $business->city->name }}</p>
    </div>
</div>