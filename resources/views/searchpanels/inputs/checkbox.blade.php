<input
        type="checkbox"
        name="{{ $name }}[]"
        value="{{ $index }}"
        @if(request()->get($name) !== null)
            @if(in_array($index, request()->get($name)))
                checked
            @endif
        @endisset
>
<hr>