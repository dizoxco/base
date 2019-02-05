<input 
class="shadow appearance-none border rounded w-full py-2 px-3 text-grey-darker leading-tight focus:outline-none focus:shadow-outline"
type="text" 
name="{{ $name }}"
@if(request()->get($name) !== null)
value="{{ request()->get($name) }}"
@endisset
>