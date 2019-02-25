<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="google-signin-scope" content="profile email">
    <meta name="google-signin-client_id" content="{{ env('GOOGLE_CLIENT_ID') }}">
    <meta name="X-CSRF-Token" content="{{ csrf_token() }}">
    <script src="https://apis.google.com/js/platform.js" async defer></script>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0"/>
    <meta name="theme-color" content="#002f6c" />
    <title>مدلا - </title>
    <link href="{{ asset('css/main.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
</head>
<body>
    <div class="designer-canvas" designer="{{$designer->id}}">
        
        <div class="toolbar">
            @component('web.designers.options', ['options' => $designer->options])@endcomponent
        </div>
        <div class="canvas">
                @php
                    // foreach ($designer->cameras[0]['layers'] as $layer_index => $layer) {
                    //     $parts = '';
                    //     foreach ($layer as $part) {
                    //         $parts .= $part.$designer->parts[$part]['variations'][0];
                    //     }
                    //     echo $designer->cameras[0]['name'] . '-' . $layer_index . '_' . $parts . '_' . '.png';
                    //     echo '<br>';
                    // }
                @endphp
        </div>
    </div>
    <script src="/js/app.js"></script>
</body>
</html>