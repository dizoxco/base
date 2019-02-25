@extends('profile.layout', ['title' => 'آدرس ها'])
@section('profile-actions')
    @component('components.form.button',[
        'label' => 'افزودن آدرس',
        'link' => route('profile.addresses.create')
    ])                    
    @endcomponent
@endsection
@section('profile-content')
    <div class="flex flex-wrap -mx-2">
        @foreach($addresses as $address)
            <div class=" flex w-1/2">
                <div class="m-2 p-2 bg-grey-lighter p-6 rounded-lg relative w-full">
                    <p class="py-2"><strong class="text-grey-dark"> گیرنده : </strong>{{ $address->receiver }}</p>
                    <p class="py-2"><strong class="text-grey-dark"> شهر : </strong>{{ $address->city->name }}</p>
                    <p class="py-2"><strong class="text-grey-dark"> آدرس : </strong>{{ $address->address }}</p>
                    <p class="py-2"><strong class="text-grey-dark"> موبایل : </strong>{{ $address->mobile }}</p>
                    <p class="py-2"><strong class="text-grey-dark"> کد پستی : </strong>{{ $address->postal_code }}</p>
                    <div class="absolute pin-l pin-b ml-6 mb-4">
                        @component('components.form.button',[
                            'label' => 'ویرایش',
                            'link' => route('profile.addresses.edit', $address),
                            'dense' => true,
                            'type' => 'text',
                        ])                    
                        @endcomponent
                        @component('components.form.button',[
                            'label' => 'حذف',
                            'link' => route('profile.addresses.destroy', $address),
                            'dense' => true,
                            'type' => 'text',
                        ])                    
                        @endcomponent
                    </div>
                </div>
            </div>
            <tr>
        @endforeach
    </div>
@endsection
