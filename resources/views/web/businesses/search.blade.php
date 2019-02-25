@extends('layout')
@section('content')
<br>
    <div class="flex flex-wrap container">
        <div class="w-1/4 pl-4 search-panel-options">
                @forelse($options as $name => $option)
                @if ($option['query'] !== 'order')
                <div class="relative rounded-lg bg-white py-2 px-6 mb-4">
                    <div class="flex items-center justify-between collapse cursor-pointer">
                        <p class="body-2" >{{ $option['label'] }}</p>
                        <i class="material-icons">expand_less</i>
                    </div>
                    <div>
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
                                    @component('components.form.text', [
                                        'label' => 'جستجو',
                                        'outlined' => true,
                                        'name' => $name,
                                        'value' => request()->get($name)
                                    ])@endcomponent
                                    @break
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
            <div class="flex flex-wrap justify-between rounded-full caption leading-none bg-white py-2 px-8 mb-5">
                <div class="flex items-center">
                    <i class="material-icons text-grey-light pr-6" style="transform:scaleX(-1)">sort</i></span>
                    @foreach ($options as $option)
                        @if ($option['query'] == 'order')
                            @foreach ($option['order'] as $index => $order)
                                <a class="no-underline text-black rounded-full px-4 mx-1" style="line-height: 2.35rem" href="{{ request()->fullUrlWithQuery(['order' => $index]) }}">{{$order['label']}}</a>
                            @endforeach
                        @endif
                    @endforeach
                </div>
            </div>
            <div class="flex flex-wrap -m-3">
                @forelse($businesses as $business)
                    <div class="w-1/2 lg:w-1/3 p-1 md:p-3">
                        @component('web.businesses.card', ['business' => $business])@endcomponent
                    </div>
                @empty
                    <p> هیچ محصولی برای این پنل تعریف نشده است. </p>
                @endforelse
            </div>
            <div class="grid-pager container text-center py-10">
                {{ $businesses->links() }}
            </div>
        </div>
    </div>
@endsection