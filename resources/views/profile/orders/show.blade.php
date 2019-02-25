@extends('profile.layout', ['title' => 'سفارش #'.$order->id])
@section('profile-content')
    <div class="flex items-center w-1/2 pl-4">
        <div class="text-grey-dark font-bold pl-4 my-2 ">شماره سفارش:</div>{{ $order->id }}
    </div>
    <div class="flex items-center w-1/2 pl-4">
        <div class="text-grey-dark font-bold pl-4 my-2 ">تاریخ سفارش:</div>{{ $order->created_at->diffForHumans() }}
    </div>
    <div class="flex items-center w-1/2 pl-4">
        <div class="text-grey-dark font-bold pl-4 my-2 ">وضضعیت سفارش:</div>{{ $order->status }}
    </div>
    <div class="bg-grey-lighter rounded-lg p-10 my-8" >
        <div class="font-bold mb-6">اطلاعات سفارش دهنده</div>
        <div class="flex ">
            <div class="flex items-center w-1/2 pl-4">
                <div class="text-grey-dark font-bold pl-4 my-2 ">نام:</div>{{ $order->user->name }}
            </div>
            <div class="flex items-center w-1/2">
                <div class="text-grey-dark font-bold pl-4 my-2 ">تلفن:</div>{{ $order->mobile }}
            </div>
        </div>
        <div class="flex ">
            <div class="flex items-center w-1/2 pl-4">
                <div class="text-grey-dark font-bold pl-4 my-2 ">آدرس:</div>{{ $order->address }}
            </div>
            <div class="flex items-center w-1/2">
                <div class="text-grey-dark font-bold pl-4 my-2 ">کد پستی:</div>{{ $order->postal_code }}
            </div>
        </div>
        <div class="flex ">
            <div class="flex items-center w-1/2 pl-4">
                <div class="text-grey-dark font-bold pl-4 my-2 ">هزینه ارسال:</div>نداریم
            </div>
            <div class="flex items-center w-1/2">
                <div class="text-grey-dark font-bold pl-4 my-2 ">نحوه ارسال:</div>نداریم
            </div>
        </div>
    </div>
    <table class="my-10">
        <thead>
            <th> ردیف </th>
            <th>نام محصول</th>
            <th>تعداد</th>
            <th>قیمت واحد</th>
            <th>قیمت کل</th>
            <th>قیمت نهایی</th>
            <th></th>
        </thead>
        <tbody>
            @foreach($order->variations as $variation)
                <tr class="collapse">
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
                        {{ $variation->pivot->price * $variation->pivot->quantity }}
                    </td>
                    <td>
                        <i class="material-icons">expand_more</i>
                    </td>
                </tr>
                <tr class="colapsable hidden">
                    <td colspan="8">
                        <div class="flex justify-between items-center">
                            <div>
                                {{ $variation->business->brand }}
                            </div>
                            <div>
                                <span class="pl-6">زمان تحویل</span>{{ $order->created_at->addDays($variation->delivery)->diffForHumans() }}
                            </div>
                            <div>
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
                            </div>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
        <tr class="text-lg">
            <td>
                @php
                $total = $order->variations->reduce(function ($carry, $variation) {
                    return $carry + ($variation->pivot->quantity * $variation->pivot->price);
                });
                @endphp
                جمع کل :
            </td>
            <td colspan="5"></td>
            <td>@toman($total)</td>
        </tr>
        
        <tr class="text-lg">
            <td>هزینه ارسال</td>
            <td colspan="5"></td>
            <td>0</td>
        </tr>
        <tr class="text-lg">
            <td>مالیات</td>
            <td colspan="5"></td>
            <td>0</td>
        </tr>
        <tr class="font-bold text-xl">
            <td> قابل پرداخت :</td>
            <td colspan="5"></td>
            <td>@toman($total)</td>
        </tr>
    </table>
@endsection