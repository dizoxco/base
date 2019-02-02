@extends('layout')
@section('content')
    <div class="flex flex-wrap">
        <div class="w-1/4">
            <h1>فیلترها</h1>
            <form target="_self">
                @forelse($options as $name => $option)
                    <label >{{ $option['label'] }}</label>
                    <hr>
                    @forelse(array_wrap($option[$option['query']]) as $index => $filter)
                        @isset($filter['label'])
                            <label >{{ $filter['label'] }}</label>
                        @endisset
                        @switch($option['query'])
                            @case('tag')
                                @include('searchpanels.inputs.checkbox', compact('name'))
                                @break
                            @case('like')
                                @include('searchpanels.inputs.textbox', compact('name', 'option'))
                                @break
                            @case('order')
                                @include('searchpanels.inputs.link', compact('name','index', 'filter'))
                                @break
                        @endswitch
                    @empty
                        <p>هیچ فیلتری تعریف نشده است</p>
                    @endforelse
                @empty
                    <h1>انتخابی وجود ندارد.</h1>
                @endforelse
                <button type="submit" class="-btn border-blue-dark border-2">search</button>
            </form>
        </div>
        <div class="w-3/4">
            @forelse($products as $product)
                <h3> {{ $product->title }}</h3>
                <p>{{ $product->tags->pluck('label') }}</p>
                <p>{{ $product->created_at->diffForHumans() }}</p>
            @empty
                <h1> هیچ محصولی برای این پنل تعریف نشده است. </h1>
            @endforelse
        </div>
    </div>
@endsection