@extends('layout')
@section('content')
    <div class="flex flex-wrap">
        <div class="w-1/4 pl-4">
        </div>
        <div class="w-3/4 pr-4">
            <div class="relative rounded-lg bg-white shadow-lg px-8 py-6 mb-6">
                <form action="{{ route('tickets.store') }}" method="post">
                    {{ csrf_field() }}
                    <input type="text" name="title" placeholder="عنوان" required>
                    <select name="category_id" id="category_id">
                        @foreach(enum('ticket.category') as $id => $name)
                            <option value="{{ $id }}">{{ $name }}</option>
                        @endforeach
                    </select>
                    <textarea name="body" id="body" cols="30" rows="10" placeholder="متن پیام" required></textarea>
                    <button type="submit">ذخیره تیکت </button>
                </form>
            </div>
            <div class="relative rounded-lg bg-white shadow-lg px-8 py-6 mb-4 ">
            </div>
            <div class="flex flex-wrap">
            </div>
        </div>

    </div>
@endsection