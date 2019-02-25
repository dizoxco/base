<form
        action="{{ $action }}"
        @isset($method) method="POST" @endisset
        @isset($enctype) enctype="multipart/form-data" @endisset
        @isset($id) id="{{ $id }}" @endisset
        autocomplete="off"
        class="flex flex-wrap -mx-2"
>
    @isset($method) {{ csrf_field() }} {{ method_field($method) }} @endisset
    {{ $slot }}
</form>
  