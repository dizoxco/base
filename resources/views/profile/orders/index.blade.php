@extends('profile.layout', ['title' => 'سفارشات', 'fit' => true])
@section('profile-content')
<table class="table-patch">
        <thead>
                <tr>
                        <th>ردیف سفارش</th>
                        <th>شناسه سفارش</th>
                        <th>تاریخ ثبت سفارش</th>
                        <th>وضعیت تحویل</th>
                        <th>مبلغ قابل پرداخت</th>
                        <th>مبلغ کل</th>
                        <th>وضعیت پرداخت</th>
                        <th>جزییات</th>
                </tr>
        </thead>
        <tbody>
                @forelse($orders as $order)
                        <tr href="{{route('profile.orders.show', $order)}}">
                                <td>
                                        {{ $loop->index * request('per_page') + 1 }}
                                </td>
                                <td>
                                        {{ $order->id }}
                                </td>
                                <td>
                                        {{ $order->created_at->diffForHumans() }}
                                </td>
                                <td>
                                        {{ array_column(enum('order.status'),'label')[$order->status] ?? '-' }}
                                </td>
                                <td>
                                        @toman($order->cost)
                                </td>
                                <td>
                                        @toman($order->cost)
                                </td>
                                <td>
                                        @toman($order->paid)
                                </td>
                                <td>
                                        <a href="{{ route('profile.orders.show', $order) }}">
                                                <span> > </span>
                                        </a>
                                </td>
                        </tr>
                @empty
                        <td colspan="4">شما سفارشی ندارید</td>
                @endforelse
        </tbody>
</table>
@endsection