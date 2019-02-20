@extends('profile.businesses.layout', ['title' => $product->title])
@section('profile-content')
    @component('components.form',[
        'action' => route('profile.businesses.products.update',[$business->slug, $product->slug]),
        'method' => 'put'
    ])
        <table>
            <tr>
                <th>نوع محصول</th>
                <th>قیمت</th>
                <th>تعداد</th>
                <th>تحویل</th>
            </tr>
            @foreach($variations as $index => $variation)
                <tr>
                    <td>
                        @foreach($variation as $column)
                            {{ $column['label'] }}
                        @endforeach
                    </td>
                    <td>
                        <input class="mdc-text-field__input" type="text" name="price{{ $index }}">
                    </td>
                    <td>
                        <input class="mdc-text-field__input" type="text" name="quantity{{ $index }}">
                    </td>
                    <td>
                        <input class="mdc-text-field__input" type="text" name="delivery{{ $index }}">
                    </td>
                </tr>
            @endforeach
        </table>
    @endcomponent
@endsection