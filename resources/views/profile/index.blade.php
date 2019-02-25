@extends('profile.layout')

@section('profile-content')
    <div class="flex flex-wrap">
        <h1>پروفایل</h1>
    </div>
    نام : {{ $user->full_name }}
    @component('components.form.field')
    @endcomponent
    ایمیل : {{ $user->email }}
        @if($user->hasVerified('email'))
            ایمیل تایید شده است
            <i class="material-icons bg-green" >done</i>
        @endif
    @component('components.form.field')
    @endcomponent
    موبایل : {{ $user->mobile }} تایید موبایل
        @if($user->hasVerified('mobile'))
            موبایل تایید شده است
            <i class="material-icons bg-green" >done</i>
        @endif
    @component('components.form.field')
    @endcomponent
    عضویت از : {{ $user->created_at->diffForHumans() }}
    @component('components.form.field')
    @endcomponent
    آخرین به روزرسانی : {{ $user->updated_at->diffForHumans() }}
    <hr>
    <table class="table-patch">
        <thead>
        <tr>
            <th>ردیف</th>
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
        @forelse($user->orders as $order)
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
                    <i class="material-icons align-middle">chevron_left</i>
                </td>
            </tr>
        @empty
            <td colspan="4">شما سفارشی ندارید</td>
        @endforelse
        </tbody>
    </table>
@endsection