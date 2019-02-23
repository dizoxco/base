@extends('layout')
@section('content')
    <div class="swiper simple -mx-4 overflow-hidden" column="3" >
        <div class="swiper-wrapper">
            @forelse ($posts as $post)
                <div class="swiper-slide">
                    <div class="p-4">
                        {{$post->title}}
                    </div>
                </div>
            @empty
                There is no posts yet!
            @endforelse
        </div>
    </div>    




    <div class="container medium flex flex-wrap">
            @component('components.form.text',[
                'label' => 'نام خانوادگی',
            ])
            @endcomponent
            @component('components.form.field')
        
            @endcomponent
            @component('components.form.text',[
                'label' => 'نام',
                'icon' => 'add',
            ])
            @endcomponent
            @component('components.form.text',[
                'label' => 'نام',
                'icon' => 'add',
            ])
            @endcomponent
            @component('components.form.text',[
                'label' => 'نام',
                'icon' => 'add',
                'icon_front' => 'sd'
            ])
            @endcomponent
        
            @component('components.form.text',[
                'label' => 'dfsd',
                'shaped' => true
            ])
            @endcomponent
            <div class="w-1/2"></div>
            @component('components.form.text',[
                'label' => 'dfsd',
                'icon' => 'add',
                'shaped' => true
            ])
            @endcomponent
            @component('components.form.text',[
                'label' => 'dfsd',
                'icon' => 'add',
                'shaped' => true,
                'icon_front' => 'sd'
            ])
            @endcomponent
        
            @component('components.form.field', ['full' => true])
                @component('components.form.button',[
                    'label' => 'ذخیره',
                    'type' => 'text'
                ])
                @endcomponent
                @component('components.form.button',[
                    'label' => 'ذخیره',
                    'type' => 'text',
                    'icon' => 'favorite'
                ])
                @endcomponent
                @component('components.form.button',[
                    'label' => 'ذخیره',
                    'type' => 'text',
                    'dense' => true
                ])
                @endcomponent
                @component('components.form.button',[
                    'label' => 'ذخیره',
                    'type' => 'text',
                    'icon' => 'favorite',
                    'dense' => true
                ])
                @endcomponent
            @endcomponent
            @component('components.form.field', ['full' => true])
                @component('components.form.button',[
                    'label' => 'ذخیره',
                    'type' => 'outlined'
                ])
                @endcomponent
                @component('components.form.button',[
                    'label' => 'ذخیره',
                    'type' => 'outlined',
                    'icon' => 'favorite'
                ])
                @endcomponent
                @component('components.form.button',[
                    'label' => 'ذخیره',
                    'type' => 'outlined',
                    'dense' => true,
                ])
                @endcomponent
                @component('components.form.button',[
                    'label' => 'ذخیره',
                    'type' => 'outlined',
                    'icon' => 'favorite',
                    'dense' => true,
                ])
                @endcomponent
            @endcomponent
            @component('components.form.field', ['full' => true])
                @component('components.form.button',[
                    'label' => 'ذخیره'
                ])
                @endcomponent
                @component('components.form.button',[
                    'label' => 'ذخیره',
                    'icon' => 'favorite'
                ])
                @endcomponent
                @component('components.form.button',[
                    'label' => 'ذخیره',
                    'dense' => true
                ])
                @endcomponent
                @component('components.form.button',[
                    'label' => 'ذخیره',
                    'icon' => 'favorite',
                    'dense' => true
                ])
                @endcomponent
        
            @endcomponent
            @component('components.form.field', ['full' => true])
                <button class="mdc-icon-button material-icons" data-mdc-auto-init="mdc-ripple" data-mdc-ripple-is-unbounded>favorite</button>
                <button class="mdc-icon-button material-icons" data-mdc-auto-init="mdc-ripple" data-mdc-ripple-is-unbounded >favorite</button>
            @endcomponent
            @component('components.form.field', ['full' => true])
                @component('components.form.checkbox',[
                    'name' => 'fsdf'
                ])
                @endcomponent
                @component('components.form.checkbox',[
                    'name' => 'if'
                ])
                @endcomponent
            @endcomponent
            @component('components.form.field', ['full' => true])
                @component('components.form.radio',[
                    'name' => 'sdf',
                    'value' => 1
                ])
                @endcomponent
                @component('components.form.radio',[
                    'name' => 'sdf',
                    'value' => 2
                ])
                @endcomponent
            @endcomponent
            @component('components.form.select',[
                'name' => 'sdf',
                'value' => 1
            ])
            @endcomponent
            @component('components.form.select',[
                'name' => 'sdf',
                'value' => 2
            ])
            @endcomponent
        </div>
@endsection