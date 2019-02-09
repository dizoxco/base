@php
    $class = (isset($half) && $half)? 'p-2 w-1/2': 'p-2 w-full';
@endphp
<div class="{{$class}}">
    {{$slot}}
</div>