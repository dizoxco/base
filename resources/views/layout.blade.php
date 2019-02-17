<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="google-signin-scope" content="profile email">
    <meta name="google-signin-client_id" content="{{ env('GOOGLE_CLIENT_ID') }}">
    <script src="https://apis.google.com/js/platform.js" async defer></script>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0"/>
    <meta name="theme-color" content="#002f6c" />
    <title>مدلا - @yield('title')</title>
    <link href="{{ asset('css/main.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
</head>
<body class="@isset($profile_mode) profile @endisset" dir="rtl">
@component('components.nav.simple') @endcomponent

<div id="content" class="min-h-screen/7">
    @yield('content')
</div>
<div class="container medium flexzz flex-wrap hidden">
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
{{-- @component('components.links', ['nav' => 'main'])@endcomponent --}}
@if(!isset($profile_mode))
    <div class="footer bg-white">
        @component('components.footer') @endcomponent
    </div>
@endif
<script src="/js/app.js"></script>
<script>
    gapi.load('auth2', function() {
        gapi.auth2.init();
    });
    function onSignIn(googleUser) {
        var xhr;
        var id_token = googleUser.getAuthResponse().id_token;
        xhr = new XMLHttpRequest();
        xhr.open('POST', '{{ route('google') }}');
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.setRequestHeader('X-CSRF-Token', "{{ csrf_token() }}");
        xhr.onload = function() {
            if (xhr.status === 200) {
                window.location.reload();
            } else if(xhr.status === 404) {
                alert('invalid person');
            } else if(xhr.status === 500) {
                alert(' server error = ' + xhr.responseText);
            } else {
                alert(' unknown');
            }
        };
        xhr.send('token=' + id_token);
    }
</script>
<script>
    $('#btn_side_login').click(function (event) {
        event.preventDefault();
        $.post( "{{ route('api.auth.login') }}", {
            service : $("#frm_side_login").find("input[name='service']").val(),
            password : $("#frm_side_login").find("input[name='password']").val(),
            remember : $("#frm_side_login").find("input[name='remember']").val()
        }).done(function (data) {
            document.cookie = "token="+data.access_token+";path=/";
            $("#frm_side_login").submit();
        }).fail(function (data) {
            alert(data.responseText)
        });
    });

    $('#btn_side_register').click(function (event) {
        event.preventDefault();
        $.post( "{{ route('api.auth.register') }}", {
            name : $("#frm_side_register").find("input[name='name']").val(),
            service : $("#frm_side_register").find("input[name='service']").val(),
            password : $("#frm_side_register").find("input[name='password']").val(),
            password_confirmation : $("#frm_side_register").find("input[name='password_confirmation']").val(),
            terms : $("#frm_side_register").find("input[name='terms']").val(),
        }).done(function (data) {
            $("#frm_side_login").find("input[name='service']").val(
                $("#frm_side_register").find("input[name='service']").val(),
            );

            $("#frm_side_login").find("input[name='password']").val(
                $("#frm_side_register").find("input[name='password']").val(),
            );

            $("#frm_side_login").submit();
        }).fail(function (data) {
            alert(data.responseText)
        });
    });
</script>
</body>
</html>