<div class="search-resulat__tag">
    <span class="font-bold">نتایج جستجو</span>
    <ul>
        @foreach ($tags as $tag)
            <li><a href="#">{{$tag->label}}</a></li>
        @endforeach
    </ul>
</div>
<div class="search-result__brands">
    <span class="font-bold">فروشندگان</span>
    <ul>
        @foreach ($bussinesses as $business)
            <li><a href="#">{{$business->brand}}</a></li>
        @endforeach
    </ul>
</div>