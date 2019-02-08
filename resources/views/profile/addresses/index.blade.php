@extends('layout')
@section('content')
<div class="container large">
    <table>
        <thead>
        <tr>
            <th>شهر</th>
            <th>آدرس</th>
            <th>گیرنده</th>
            <th>موبایل</th>
            <th>موبایل</th>
        </tr>
        </thead>
        <tbody>
            @forelse($addresses as $address)
                <tr>

                    <td> گیرنده : {{ $address->receiver }}</td>
                    <td> موبایل : {{ $address->mobile }}</td>
                    <td> شهر : {{ $address->city->name }}</td>
                    <td> آدرس : {{ $address->address }}</td>
                    <td> کد پستی : {{ $address->postal_code }}</td>
                </tr>
            @empty
                You have no address submitted yet!
            @endforelse
        </tbody>
    </table>
</div>
@endsection
