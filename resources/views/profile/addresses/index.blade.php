@extends('profile.layout', ['title' => 'آدرس ها'])
@section('profile-content')
    <div class="flex flex-wrap -mx-2">
        <div class="w-1/2">
            <div class="m-2 p-2 bg-white">
                <h2>افزودن آدرس جدید</h2>
                @component('components.form.button',[
                    'label' => 'add',
                    'link' => route('profile.addresses.create')
                ])                    
                @endcomponent
            </div>
        </div>
        @foreach($addresses as $address)
            <div class="w-1/2">
                <div class="m-2 p-2 bg-white">
                    <p><strong> گیرنده : </strong>{{ $address->receiver }}</p>
                    <p><strong> موبایل : </strong>{{ $address->mobile }}</p>
                    <p><strong> شهر : </strong>{{ $address->city->name }}</p>
                    <p><strong> آدرس : </strong>{{ $address->address }}</p>
                    <p><strong> کد پستی : </strong>{{ $address->postal_code }}</p>
                    @component('components.form.button',[
                    'label' => 'ویرایش',
                    'link' => route('profile.addresses.edit', $address)
                    ])                    
                    @endcomponent
                    @component('components.form.button',[
                        'label' => 'حذف',
                        'link' => route('profile.addresses.create')
                    ])                    
                    @endcomponent
                </div>
            </div>
            <tr>
        @endforeach
    </div>
@endsection
