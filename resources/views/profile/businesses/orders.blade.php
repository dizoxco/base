@extends('profile.businesses.layout', ['title' => "لیست سفارشات $business->brand "])
@section('title', $business->brand)
@section('profile-content')
    <table>
        <tr>
            <th>کد سفارش</th>
            <th>خریدار</th>
            <th>گیرنده</th>
            <th>موبایل</th>
            <th>شهر</th>
            <th>آدرس</th>
            <th>کد پستی</th>
            <th>وضعیت</th>
            <th>تاریخ ایجاد</th>
            <th>تاریخ به روزرسانی</th>
        </tr>
        @forelse($orders as $order)
            <tr>
                <td>
                    <a href="{{ route('profile.businesses.show.orders.show', [$business->slug, $order]) }}">
                        {{ $order->id }}
                    </a>
                </td>
                <td>{{ $order->user->fullname }}</td>
                <td>{{ $order->receiver }}</td>
                <td>{{ $order->mobile }}</td>
                <td>{{ $order->city->name }}</td>
                <td>{{ $order->address }}</td>
                <td>{{ $order->postal_code }}</td>
                <td>{{ $order->done ? 'Complete' : 'inComplete' }}</td>
                <td>{{ $order->created_at->diffForHumans() }}</td>
                <td>{{ $order->updated_at->diffForHumans() }}</td>
            </tr>
        @empty
        @endforelse
    </table>
@endsection