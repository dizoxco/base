@extends(isset($business)? 'profile.businesses.layout' :'profile.layout', ['title' => 'افزودن کسب و کار'])
@section('profile-content')
    @component('components.form', $form)
        @component('components.form.text', [
            'label' => 'نام تجاری',
            'name' => 'brand',
            'half' => true,
            'value' => old('brand', $business->brand ?? '')
        ])
        @endcomponent

        @component('components.form.select',[
            'label' => 'شهر',
            'name' => 'city_id',
            'value' => old('city_id', $business->city_id ?? ''),
            'half' => true,
            'options' => cities()->pluck('name', 'id')
        ])
        @endcomponent
    
        <div class="w-full">
            <br>
            <p>
                شماره های تماس
            </p>
            @component('components.form.addable', ['new' => true])
                @isset($business->contact['tel'])
                    @slot('items')
                        @php
                            $length = max(
                                count($business->contact['tel']['title']),
                                count($business->contact['tel']['value'])
                                ) - 1;
                        @endphp
                        @for($i = 0; $i <= $length; $i++)
                            @component('components.form.addable-item')
                                <div class="w-full flex">
                                    @component('components.form.text',[
                                        'label' => 'عنوان تلفن',
                                        'name' => "contact[tel][title][$i]",
                                        'value' => $business->contact['tel']['title'][$i],
                                    ])
                                    @endcomponent
                                    @component('components.form.text',[
                                        'label' => 'شماره تلفن',
                                        'name' => "contact[tel][value][$i]",
                                        'value' => $business->contact['tel']['value'][$i],
                                    ])
                                    @endcomponent
                                </div>
                            @endcomponent
                        @endfor
                    @endslot
                @endisset
                <div class="flex w-full">
                @component('components.form.text',[
                    'label' => 'عنوان تلفن',
                    'name' => 'contact[tel][title][]',
                ])
                @endcomponent
                @component('components.form.text',[
                    'label' => 'شماره تلفن',
                    'name' => 'contact[tel][value][]',
                ])
                @endcomponent
                </div>
            @endcomponent
            <hr>
        </div>
        <div class="w-full">
            <br>
            <p>
                اینستاگرام
            </p>
            @component('components.form.addable', ['new' => true])
                @isset($business->contact['instagram'])
                    @slot('items')
                        @php
                            $length = max(
                                count($business->contact['instagram']['title']),
                                count($business->contact['instagram']['value'])
                                ) - 1;
                        @endphp
                        @for($i = 0; $i <= $length; $i++)
                            @component('components.form.addable-item')
                                <div class="w-full flex">
                                    @component('components.form.text',[
                                        'label' => 'عنوان تلفن',
                                        'name' => "contact[instagram][title][$i]",
                                        'value' => $business->contact['instagram']['title'][$i],
                                    ])
                                    @endcomponent
                                    @component('components.form.text',[
                                        'label' => 'شماره تلفن',
                                        'name' => "contact[instagram][value][$i]",
                                        'value' => $business->contact['instagram']['value'][$i],
                                    ])
                                    @endcomponent
                                </div>
                            @endcomponent
                        @endfor
                    @endslot
                @endisset
                <div class="w-full flex">
                    @component('components.form.text',[
                        'label' => 'عنوان صفحه',
                        'name' => 'contact[instagram][title][]',
                    ])
                    @endcomponent
                    @component('components.form.text',[
                        'label' => 'آدرس صفحه',
                        'name' => 'contact[instagram][value][]',
                    ])
                    @endcomponent
                </div>
            @endcomponent
            <hr>
        </div>
        @component('components.form.field')
            @component('components.form.button',[
                'label' => 'ذخیره'
            ])
            @endcomponent
        @endcomponent
    @endcomponent
@endsection
