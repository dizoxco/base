@php
    $variations = $product->combinedVariations;
@endphp
@extends('profile.businesses.layout', ['title' => $product->title])
@section('profile-content')
    @component('components.form',[
        'action' => route('profile.businesses.products.update',[$business->slug, $product->slug]),
        'method' => 'put'
    ])
        <table>
            <tr>
                <th>وضعیت</th>
                @foreach ($product->options as $option)
                    <th>{{$option['label']}}</th>
                @endforeach
                <th>قیمت</th>
                <th>تعداد</th>
                <th>تحویل</th>
            </tr>
            @foreach($variations as $variation_index => $variation)
                <tr>
                    <td>
                        @switch($variation['variation']->status ?? 200)
                            @case(0) تایید نشده @break
                            @case(1) تایید شده @break
                            @default تعریف نشده
                        @endswitch
                    </td>
                    @foreach($variation['options'] as $option_value)
                        <td>
                            {{ $option_value['label'] }}
                        </td>
                    @endforeach
                    <td>
                        <input class="mdc-text-field__input" type="text" name="variations[{{$variation_index}}][price]" value="{{$variation['variation']->price ?? 0}}">
                    </td>
                    <td>
                        <input class="mdc-text-field__input" type="text" name="variations[{{$variation_index}}][quantity]" value="{{$variation['variation']->quantity ?? 0}}">
                    </td>
                    <td>
                        <input class="mdc-text-field__input" type="text" name="variations[{{$variation_index}}][delivery]" value="{{$variation['variation']->delivery ?? 0}}">
                    </td>
                </tr>
            @endforeach
        </table>
        @component('components.form.button',[
            'label' => 'ذخیره'
        ])
            
        @endcomponent
    @endcomponent
@endsection