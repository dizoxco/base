@extends('profile.layout', ['title' => 'سفارش #'.$order->id])
@section('profile-content')
    شماره سفارش  : {{ $order->id }}
    <br>
    تاریخ سفارش  : {{ $order->created_at->diffForHumans() }}
    <br>
    وضعیت سفارش  : {{ $order->status }}
    <br>
    <table>
        <tr>
            <th> ردیف </th>
            <th>نام محصول</th>
            <th>تعداد</th>
            <th>قیمت واحد</th>
            <th>قیمت کل</th>
            <th>تخفیف</th>
            <th>عملیات</th>
            <th>قیمت نهایی</th>
            <th>فروشنده</th>
            <th>تاریخ تحویل</th>
            <th>ارتباط با فروشنده</th>
        </tr>
    @foreach($order->variations as $variation)
        <tr>
            <td>
                {{ $loop->index + 1 }}
            </td>
            <td>
                {{ $variation->product->title }}
            </td>
            <td>
                {{ $variation->pivot->quantity }}
            </td>
            <td>
                {{ $variation->pivot->price }}
            </td>
            <td>
                {{ $variation->pivot->price * $variation->pivot->quantity }}
            </td>
            <td>
                -
            </td>
            <td>
                -
            </td>
            <td>
                {{ $variation->pivot->price * $variation->pivot->quantity }}
            </td>
            <td>
                {{ $variation->business->brand }}
            </td>
            <td>
                {{ $order->created_at->addDays($variation->delivery)->diffForHumans() }}
            </td>
            <td>
                @forelse($variation->business->contact as $contact => $details)
                    @forelse($details as $detail)
                        {{ $detail['label'] }} : {{ $detail['value'] }}
                        <br>
                    @empty
                        no contact
                    @endforelse
                    <br>
                @empty
                    آدرس ندارد
                @endforelse
            </td>
        </tr>
    @endforeach
    </table>
    <table>

        <br>
        <h1>نهایی</h1>
        @php
            $total = $order->variations->reduce(function ($carry, $variation) {
                return $carry + ($variation->pivot->quantity * $variation->pivot->price);
            });
        @endphp
        جمع کل : @toman($total)
        <br>
        هزینه ارسال : 0
        <br>
        مالیات : 0
        <br>
        قابل پرداخت : @toman($total)

    <br>
    <h1>سفارش دهنده</h1>
        نام : {{ $order->user->name }}
        <br>
        آدرس : {{ $order->address }}
        <br>
        تلفن : {{ $order->mobile }}
        <br>
        کدپستی : {{ $order->postal_code }}
        <br>
        هزینه ارسال : نداریم
        <br>
        نحوه ارسال : نداریم
@endsection