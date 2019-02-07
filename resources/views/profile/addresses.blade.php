<ol>
    @forelse($addresses as $address)
            <li> گیرنده : {{ $address->receiver }}</li>
            <li> موبایل : {{ $address->mobile }}</li>
            <li> شهر : {{ $address->city->name }}</li>
            <li> آدرس : {{ $address->address }}</li>
            <li> کد پستی : {{ $address->postal_code }}</li>
    @empty
        You have no address submitted yet!
    @endforelse
</ol>