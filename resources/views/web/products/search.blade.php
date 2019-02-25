@extends('layout')
@section('content')
<br>
    <div class="flex flex-wrap container ">
        <div class="hidden md:block md:w-1/4 px-4 search-panel-options">
                @forelse($options as $name => $option)
                @if ($option['query'] !== 'order')
                <div class="relative rounded-lg bg-white py-2 px-6 mb-4 ">
                    <div class="flex items-center justify-between collapse cursor-pointer">
                            <p class="body-2" >{{ $option['label'] }}</p>
                            <i class="material-icons">expand_less</i>
                    </div>
                    <div>
                        @forelse(array_wrap($option[$option['query']]) as $index => $filter)
                            @switch($option['query'])
                                @case('tag')
                                @php
                                    // dd(request()->get($name))
                                @endphp
                                        @component('components.form.checkbox', [
                                            'name' => "{$name}[{$index}]",
                                            'label' => $filter['label'],
                                            'value' => $index,
                                            'checked' => !empty(request()->get($name)) && in_array($index, request()->get($name))
                                        ])
                                        @endcomponent
                                        {{-- @include('searchpanels.inputs.checkbox', compact('name'))
                                        @isset($filter['label'])
                                            <label >{{ $filter['label'] }}</label>
                                        @endisset --}}
                                        <br>
                                    @break
                                @case('like')
                                    {{-- @include('searchpanels.inputs.textbox', compact('name', 'option')) --}}
                                    @component('components.form.text', [
                                        'label' => 'جستجو',
                                        'outlined' => true,
                                        'name' => $name,
                                        'value' => request()->get($name)
                                    ])@endcomponent
                                    @break
                                {{-- @case('order')
                                    @include('searchpanels.inputs.link', compact('name','index', 'filter'))
                                    @break --}}
                            @endswitch
                        @empty
                            <p>هیچ فیلتری تعریف نشده است</p>
                        @endforelse
                    </div>
                </div>
                @endisset

                @empty
                    <p>انتخابی وجود ندارد.</p>
                @endforelse               
        </div>
        <div class="w-full md:w-3/4 px-4 search-panel-result">
            <div class="md:flex md:flex-wrap justify-between rounded-full caption leading-none bg-white py-2 px-8 mb-5 hidden">
                <div class="flex items-center hidden">
                    <i class="material-icons text-grey-light pr-6" style="transform:scaleX(-1)">sort</i></span>
                    @foreach ($options as $option)
                        @if ($option['query'] == 'order')
                            @foreach ($option['order'] as $index => $order)
                                <a class="no-underline text-black rounded-full px-4 mx-1 " style="line-height: 2.35rem" href="{{ request()->fullUrlWithQuery(['order' => $index]) }}">{{$order['label']}}</a>
                            @endforeach
                        @endif
                    @endforeach
                </div>
            </div>
            <div class="flex flex-wrap -m-3">
                @forelse($products as $product)
                    <div class="w-1/2 lg:w-1/3 p-1 md:p-3">
                        @component('web.products.card', ['product' => $product])@endcomponent
                    </div>
                @empty
                    <p> هیچ محصولی برای این پنل تعریف نشده است. </p>
                @endforelse
            </div>
            <div class="grid-pager container text-center py-10">
                {{ $products->links() }}
            </div>
        </div>
    </div>
    <div class="flex fixed h-16 w-full pin-b bg-white shadow-inner md:hidden items-center">
        <div class="search-filters w-1/2 h-full flex items-center justify-center border-l border-solid border-grey-light">
            جستجوی تخصصی
        </div>
        <div class="search-sorting w-1/2 h-full flex items-center justify-center">
            مرتب سازی
        </div>
    </div>
@endsection