@extends('profile.layout', ['title' => 'افزودن کسب و کار'])
@section('profile-content')
    @component('components.form', $form)
        @component('components.form.text', [
            'label' => 'نام تجاری',
            'name' => 'brand',
            'half' => true,
            'value' => old('brand', $business->brand ?? '')
        ])
        @endcomponent

        @component('components.form.text', [
            'label' => 'شهر',
            'name' => 'city_id',
            'half' => true,
            'value' => old('city_id', $business->city_id ?? '')
        ])
        @endcomponent
        <div>
            <p>
                شماره های تماس
            </p>
            @component('components.form.addable')
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
                                @component('components.form.text',[
                                    'label' => 'عنوان تلفن',
                                    'name' => "contact[tel][title][$i]",
                                    'value' => $business->contact['tel']['title'][$i],
                                ])
                                @endcomponent
                            @endcomponent
                            @component('components.form.addable-item')
                                @component('components.form.text',[
                                    'label' => 'شماره تلفن',
                                    'name' => "contact[tel][value][$i]",
                                    'value' => $business->contact['tel']['value'][$i],
                                ])
                                @endcomponent
                            @endcomponent
                        @endfor
                    @endslot
                @endisset
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
            @endcomponent
            <hr>
        </div>
        <div>
            <p>
                اینستاگرام
            </p>
            @component('components.form.addable')
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
                                @component('components.form.text',[
                                    'label' => 'عنوان تلفن',
                                    'name' => "contact[instagram][title][$i]",
                                    'value' => $business->contact['instagram']['title'][$i],
                                ])
                                @endcomponent
                            @endcomponent
                            @component('components.form.addable-item')
                                @component('components.form.text',[
                                    'label' => 'شماره تلفن',
                                    'name' => "contact[instagram][value][$i]",
                                    'value' => $business->contact['instagram']['value'][$i],
                                ])
                                @endcomponent
                            @endcomponent
                        @endfor
                    @endslot
                @endisset
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
