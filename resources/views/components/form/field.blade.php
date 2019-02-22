@php
    $class = (isset($half) && $half)? 'p-3 w-1/2': 'p-3 w-full';
@endphp
<div class="{{$class}}">
    {{$slot}}
</div>