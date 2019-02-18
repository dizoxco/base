@extends('layout')
@section('content')
<br>
    <div class="container large flex">
        <div class="w-2/3">
            @component('components.form', [
                'action' => route('shipping.store'),
                'method' => 'POST',
            ])
                @forelse($addresses as $address)
                    <div class="side__cart-product flex py-3 px-5 relative bg-white mb-4 ml-2">
                        <div class="side__cart-product-img w-1/3 ">
                            ادرس ها
                        </div>
                        <div class="side__cart-product-detail caption pr-2 w-2/3">
                            <div class="side__cart-product-name text-sm text-black">
                                <div class="font-bold text-black text-lg mt-3">
                                    <input type="radio" name="address" value="{{ $address->id }}">
                                    <span class="text-sm font-normal text-black">
                                گیرنده : {{ $address->receiver }}
                                </span>
                                    <span class="text-sm font-normal text-black">
                                موبایل : {{ $address->mobile }}
                                </span>
                                    <span class="text-sm font-normal text-black">
                                شهر : {{ $address->city->name }}
                                </span>
                                    <span class="text-sm font-normal text-black">
                                کدپستی : {{ $address->postal_code }}
                                </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    @component('components.form.button',[
                        'label' => 'انتخاب آدرس',
                    ])
                    @endcomponent
                @empty
                    @component('components.form.button',[
                        'label' => 'افزودن آدرس',
                        'name' => 'btn_shipping_add_address',
                    ])
                    @endcomponent
                @endforelse
             @endcomponent
        </div>
        <div class="w-1/3">
            <div class="bg-white mr-2 p-4 text-center">
                <h4>مجموع سفارش</h4>
                <h6>@toman(auth()->user()->cartCost)</h6>
                <br>
                @component('components.form.button',[
                    'label' => 'ادامه خرید',
                ])
                @endcomponent
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        $('#btn_shipping_add_address').click(function (event) {
            event.preventDefault();
            alert('open modal');
        });
    </script>
@endsection