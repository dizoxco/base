@extends('layout')
@section('content')
    <div class="flex flex-wrap">
        <div class="w-1/4 pl-4">
        </div>
        <div class="w-3/4 pr-4">
            <div class="relative rounded-lg bg-white shadow-lg px-8 py-6 mb-6">
                <form action="{{ route('profile.addresses.update', $address) }}" method="post">
                    {{ csrf_field() }}
                    {{ method_field('put') }}
                    <input type="text" name="receiver" placeholder="گیرنده" value="{{ $address->receiver }}" required>
                    <input type="text" minlength="11" maxlength="11" name="mobile" placeholder="موبایل" value="{{ $address->mobile }}" required>
                    <select name="city_id" id="city" required>
                        <option disabled selected> --- </option>
                        @forelse($cities as $id => $name)
                            @if($id == $address->city_id)
                                <option selected value="{{ $id }}">{{ $name }}</option>
                            @else
                                <option value="{{ $id }}">{{ $name }}</option>
                            @endif
                        @empty
                            <option disabled> --- </option>
                        @endforelse
                    </select>
                    <textarea name="address" id="address" cols="30" rows="10" placeholder="آدرس" required>{{ $address->address }}</textarea>
                    <input name="postal_code" type="text" minlength="10" maxlength="10" placeholder="کد پستی" value="{{ $address->postal_code }}" required>
                    <button type="submit">به روز رسانی آدرس </button>
                </form>
            </div>
            <div class="relative rounded-lg bg-white shadow-lg px-8 py-6 mb-4 ">
            </div>
            <div class="flex flex-wrap">
            </div>
        </div>

    </div>
@endsection