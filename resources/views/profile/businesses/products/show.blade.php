@extends('profile.businesses.layout', ['title' => $product->title])
@section('profile-content')
    @component('components.form',[
        'action' => route('profile.businesses.products.update',[$business->slug, $product->slug]),
        'method' => 'put'
    ])
        <table>
            <tr>
                @foreach ($product->options as $option)
                    <th>{{$option['label']}}</th>
                @endforeach
                <th>قیمت</th>
                <th>تعداد</th>
                <th>تحویل</th>
            </tr>
            @foreach($variations as $index => $variation)
                <tr>
                    @foreach($variation as $column)
                        <td>
                            {{ $column['label'] }}
                            <input type="hidden" name="variations[{{$index}}][options][{{$column['name']}}]">
                        </td>
                    @endforeach
                    <td>
                        <input class="mdc-text-field__input" type="text" name="variations[{{$index}}][price]">
                    </td>
                    <td>
                        <input class="mdc-text-field__input" type="text" name="variations[{{$index}}][quantity]">
                    </td>
                    <td>
                        <input class="mdc-text-field__input" type="text" name="variations[{{$index}}][delivery]">
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