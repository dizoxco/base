@extends('layout')
@section('content')
<br>
    <div class="flex flex-wrap container">
        <div class="w-full md:w-1/4 px-4 search-panel-options">
                @forelse($options as $name => $option)
                @if ($option['query'] !== 'order')
                <div class="relative rounded-lg bg-white pt-2 pb-4 px-4 mb-4">
                    <p class="body-2" >{{ $option['label'] }}</p>
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
                @endisset

                @empty
                    <p>انتخابی وجود ندارد.</p>
                @endforelse               
        </div>
        <div class="w-full md:w-3/4 px-4 search-panel-result">
            <div class="flex flex-wrap justify-between rounded-full caption leading-none bg-white px-8 mb-5">
                <div class="flex items-center">
                    <i class="material-icons text-grey-light" style="transform:scaleX(-1)">sort</i></span>
                    @foreach ($options as $option)
                        @if ($option['query'] == 'order')
                            @foreach ($option['order'] as $index => $order)
                                <a class="no-underline rounded-full px-4 py-1" href="{{ request()->fullUrlWithQuery(['order' => $index]) }}">{{$order['label']}}</a>
                            @endforeach
                        @endif
                    @endforeach
                </div>
                <div class="flex items-center">
                    <i class="material-icons px-2 text-grey-light">view_module</i>
                    <i class="material-icons px-2 text-grey-light">toc</i>
                </div>

            </div>
            <div class="flex flex-wrap -m-2">
                @forelse($products as $product)
                    <div class="w-1/2 lg:w-1/3 p-3">
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
@endsection