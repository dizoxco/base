@extends('profile.layout', ['title' => 'سفارشات', 'fit' => true])
@section('profile-content')
<table class="table-patch">
        <thead>
                <tr>
                        <th>شناسه</th>
                        <th>گیرنده</th>
                        <th>موبایل</th>
                        <th>شهر</th>
                </tr>
        </thead>
        <tbody>
                @forelse($orders as $order)
                        <tr href="{{route('profile.orders.show', $order)}}">
                                <td>
                                        <a href="{{route('profile.orders.show', $order)}}">
                                                {{ $order->id }}
                                        </a>
                                </td>
                                <td>{{ $order->receiver }}</td>
                                <td>{{ $order->mobile }}</td>
                                <td>{{ $order->city->name }}</td>
                        </tr>
                @empty
                        <td colspan="4">شما سفارشی ندارید</td>
                @endforelse
        </tbody>
</table>
@endsection