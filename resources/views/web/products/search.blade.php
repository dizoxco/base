@extends('layout')
@section('content')
    <div class="flex flex-wrap container">
        <div class="w-full md:w-1/4 px-4">
            <form target="_self">
                @forelse($options as $name => $option)
                @if ($option['query'] !== 'order')
                <div class="relative rounded-lg bg-white pt-2 pb-4 px-4 mb-4">
                    <p class="body-2" >{{ $option['label'] }}</p>
                   @forelse(array_wrap($option[$option['query']]) as $index => $filter)
                        @switch($option['query'])
                            @case('tag')
                                    @include('searchpanels.inputs.checkbox', compact('name'))
                                    @isset($filter['label'])
                                        <label >{{ $filter['label'] }}</label>
                                    @endisset
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
                @component('components.form.button', [
                    'label' => 'جستجو',
                    'outlined' => true,
                    'shaped' => true
                ])@endcomponent                
            </form>
        </div>
        <div class="w-full md:w-3/4 px-4">
            <div class="flex flex-wrap relative rounded-full bg-white p-4 mb-5">
                <span class="absoulute text-grey-light pin-r mx-4"><i class="material-icons" style="transform:scaleX(-1)">sort</i></span>
                @foreach ($options as $option)
                    @if ($option['query'] == 'order')
                        @foreach ($option['order'] as $index => $order)
                            <a class="no-underline align-top rounded-full px-4 py-1" href="{{ request()->fullUrlWithQuery(['order' => $index]) }}">{{$order['label']}}</a>
                        @endforeach
                    @endif
                @endforeach
                <span class="text-grey-light flex flex-wrap md:absolute md:pin-l mx-4">
                    <i class="material-icons ">view_module</i>
                    <i class="material-icons">toc</i>
                </span>
            </div>
            <div class="flex flex-wrap -m-2">
                @forelse($products as $product)
                    <div class="w-full md:w-1/2 lg:w-1/3 p-3">
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