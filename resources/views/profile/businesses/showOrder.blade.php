@extends('profile.businesses.layout', ['title' => "سفارش شماره $order->id"])
@section('profile-content')
    <table>
        <tr>
            <th>کد سفارش</th>
            <th>خریدار</th>
            <th>کسب و کار</th>
            <th>محصول</th>
            <th>قیمت پایه</th>
            <th>تعداد سفارش</th>
            <th>قیمت کلی</th>
            <th>تاریخ ایجاد</th>
            <th>تاریخ به روزرسانی</th>
        </tr>
        @forelse($variations as $variation)
            <tr>
                <td>
                    <a href="{{ route('profile.businesses.show.orders.show', [$business->slug, $order]) }}">
                        {{ $order->id }}
                    </a>
                </td>
                <td>{{ $order->user->fullname }}</td>
                <td>{{ $business->brand }}</td>
                <td>
                    <a href="{{ route('products.show', $variation->product->slug) }}">
                        {{ $variation->product->title }}
                    </a>
                </td>
                <td>@toman($variation->price)</td>
                <td>{{ $variation->getOriginal('pivot_count') }}</td>
                <td>@toman($variation->getOriginal('pivot_count') * $variation->price)</td>
                <td>{{ $order->created_at->diffForHumans() }}</td>
                <td>{{ $order->updated_at->diffForHumans() }}</td>
            </tr>
        @empty
        @endforelse
    </table>
@endsection