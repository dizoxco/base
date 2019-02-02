<input
        type="text"
        name="{{ $name }}"
        @if(request()->get($name) !== null)
            value="{{ request()->get($name) }}"
        @endisset
>
<hr>