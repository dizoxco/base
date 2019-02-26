@extends('profile.layout', ['title' => 'پروفایل'])

@section('profile-content')
    <span class="text-grey-dark font-bold pl-4 my-2 ">نام :</span>
     {{ $user->full_name }}
    @component('components.form.field')
    @endcomponent
    @if($user->email)
        ایمیل : {{ $user->email }}
        @if($user->hasVerified('email'))
            ایمیل تایید شده است
            <i class="material-icons bg-green" >done</i>
        @endif
    @endif
    @component('components.form.field')
    @endcomponent
    @if($user->mobile)
        موبایل : {{ $user->mobile }}
        @if($user->hasVerified('mobile'))
            موبایل تایید شده است
            <i class="material-icons bg-green" >done</i>
        @endif
    @endif
    @component('components.form.field')
    @endcomponent
    <span class="text-grey-dark font-bold pl-4 my-2 ">عضویت از :</span>
    {{ $user->created_at->diffForHumans() }}
    @component('components.form.field')
    @endcomponent
    <span class="text-grey-dark font-bold pl-4 my-2 ">آخرین به روزرسانی :</span>
    {{ $user->updated_at->diffForHumans() }}
    <table class="table-patch mt-10">
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