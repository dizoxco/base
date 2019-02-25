@extends('profile.businesses.layout', ['title' => "محصولات $business->brand", 'fit' => true])
@section('profile-content')
    <table>
        <tr>
            <th>عنوان</th>
            <th>توضیح مختصر</th>
            <th>قیمت</th>
            <th>ایجاد شده در</th>
            <th>آخرین به روزرسانی</th>
        </tr>
        @forelse($products as $product)
            <tr>
                <td>
                    <a href="{{ route('profile.businesses.products.show', [$business->slug, $product->slug]) }}">
                        {{ str_limit($product->title, 60) }}
                    </a>
                </td>
                <td>{{ str_limit($product->abstract, 60) }}</td>
                <td>@toman($product->price)</td>
                <td>{{ $product->created_at->diffForHumans() }}</td>
                <td>{{ $product->updated_at->diffForHumans() }}</td>
            </tr>
        @empty
        @endforelse
        <tr></tr>
    </table>
@endsection