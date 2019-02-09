@php
    $class = (isset($full) && $full)? 'mb-4 w-full': 'mb-4 w-1/2';
@endphp
<div class="{{$class}}">
    {{$slot}}
</div>