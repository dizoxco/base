<ol>
    @forelse($orders as $order)
        <div>
                <label for="receiver"> گیرنده </label>
                <p id="receiver">{{ $order->receiver }}</p>
        </div>
                <div>
                        <label for="receiver"> موبایل </label>
                        <p id="receiver">{{ $order->mobile }}</p>
                </div>
                <div>
                        <label for="receiver"> شهر </label>
                        <p id="receiver">{{ $order->city->name }}</p>
                </div>
                <div>
                        <label for="receiver"> ادرس </label>
                        <p id="receiver">{{ $order->address }}</p>
                </div>
                <div>
                        <label for="receiver"> کدپستی </label>
                        <p id="receiver">{{ $order->postal_code }}</p>
                </div>
                <div>
                        <label for="receiver"> پرداخت </label>
                        <p id="receiver">{{ $order->done ? 'شد' : 'نشد' }}</p>
                </div>
                @php $variations = $order->variations @endphp
        <table class="table-auto">
                <th>ردیف</th>
                <th>عنوان</th>
                <th>قیمت</th>
                <th>تعداد</th>
                <th></th>
                @forelse($variations as $variation)
                        <tr class="table-row">
                                <td>{{ $loop->index+1 }}</td>
                                <td>{{ $variation->product->title }}</td>
                                <td>{{ $variation->pivot->price }}</td>
                                <td>{{ $variation->pivot->count }}</td>
                                <td>
                                        <a href="{{ route('products.show', $variation->product->slug ) }}">
                                                مشاهده محصول
                                        </a>
                                </td>
                        </tr>
                @empty
                        You pay for nothing you idiot.
                @endforelse
        </table>
        @empty
        You have no orders yet!
    @endforelse
</ol>