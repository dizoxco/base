<a href="{{ route('profile.addresses.create') }}"> ادرس جدید </a>
<ol>
    @forelse($addresses as $index => $address)
        <div>
            <li> گیرنده : {{ $address->receiver }}</li>
            <li> موبایل : {{ $address->mobile }}</li>
            <li> شهر : {{ $address->city->name }}</li>
            <li> آدرس : {{ $address->address }}</li>
            <li> کد پستی : {{ $address->postal_code }}</li>
            <li>
                <a href="{{ route('profile.addresses.edit', $address) }}">
                    ویرایش
                </a>
                <a href="{{ route('web.authlogout') }}"
                   onclick="event.preventDefault();document.getElementById('delete_{{ $index }}').submit();">
                    حذف
                </a>

                <form id="delete_{{ $index }}" action="{{ route('profile.addresses.destroy', $address) }}" method="POST" style="display: none;">
                    {{ csrf_field() }}
                    {{ method_field('delete') }}
                </form>
            </li>
        </div>
    @empty
        You have no address submitted yet!
    @endforelse
</ol>