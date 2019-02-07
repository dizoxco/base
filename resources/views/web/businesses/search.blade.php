@extends('layout')
@section('content')
    <div class="flex flex-wrap container">
        <div class="w-1/4 pl-4">
            <form target="_self">
                @forelse($options as $name => $option)
                @if ($option['query'] !== 'order')
                <div class="relative rounded-lg bg-white shadow-lg pt-2 pb-4 px-4 mb-4">
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
        <div class="w-3/4 pr-4">
            <div class="relative rounded-lg bg-white shadow-lg py-4 mb-2">
                <span class="absoulute text-grey-light pin-r mx-4"><i class="material-icons" style="transform:scaleX(-1)">sort</i></span>
                @foreach ($options as $option)
                    @if ($option['query'] == 'order')
                        @foreach ($option['order'] as $index => $order)
                            <a class="no-underline align-top rounded-full px-4 py-1" href="{{ request()->fullUrlWithQuery(['order' => $index]) }}">{{$order['label']}}</a>
                        @endforeach
                    @endif
                @endforeach
                <span class="absolute text-grey-light pin-l mx-4">
                    <i class="material-icons ">view_module</i>
                    <i class="material-icons">toc</i>
                </span>
            </div>
            <div class="flex flex-wrap">
                @forelse($businesses as $business)
                    <div class="w-1/3 px-2 py-2">
                        @component('web.businesses.card', ['business' => $business])@endcomponent
                    </div>
                @empty
                    <p> هیچ محصولی برای این پنل تعریف نشده است. </p>
                @endforelse
            </div>
        </div>
    </div>
@endsection