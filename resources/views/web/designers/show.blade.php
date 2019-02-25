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
    <script src="https://code.jquery.com/jquery-2.2.4.min.js"></script>
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
    {{-- <script src="/js/app.js"></script> --}}
    <script>

       
var designer = null;
$('.designer-canvas').ready(function(){
    $.get('/designers/'+$('.designer-canvas').attr('designer')+'/json', function(data){
        designer = data;
        designer.data = {};
        designer.order = {
            camera: null,
            parts: [],
            fabrics: [],
            render: [],
            flags: []
        };
        Object.keys(designer.flags).map(function(key, index) {
            designer.flags[key] = false;
        });
        renderDesigner();
    })
});
$('.designer-canvas .options .back').click(function(){
    $('.designer-canvas .values.active').removeClass('active');
    $(this).parent().removeClass('active');
})
$('.designer-canvas [option]').click(function(){
    $('.designer-canvas .values.active').removeClass('active');
    $(this).parent().find('.active').removeClass('active');
    $(this).addClass('active');
    $('.designer-canvas [panel='+$(this).attr('option')+']').addClass('active');
})
$('.designer-canvas .value').click(function(){
    if (!$(this).hasClass('disable')) {

        if ($(this).attr('flagup')) designer.flags[$(this).attr('flagup')] = true;
        if ($(this).attr('flagdown')) designer.flags[$(this).attr('flagdown')] = false;

        $(this).parent().find('.active').removeClass('active');
        $(this).addClass('active');
        renderDesigner();
    }
})
function renderDesigner(){
    
    var active_option = $('.designer-canvas .options .option.active');
    if (active_option.length == 0) {
        active_option = $('.designer-canvas .options .option').first();
        active_option.addClass('active');
    }
    designer.order.camera = active_option.attr('camera');
    designer.order.render = [];
    
    $('.designer-canvas .value[flag]').each(function(){
        if(designer.flags[$(this).attr('flag')])
            $(this).removeClass('disable');
        else
            $(this).addClass('disable');
    });

    $('.designer-canvas .values').each(function(){
        var active = $(this).find('.value.active').first();
        
        if (active.length == 0) {
            active = $(this).find('.value').first();
            active.addClass('active');
        }
        if (active.attr('flagup')) designer.flags[active.attr('flagup')] = true;
        if (active.attr('flagdown')) designer.flags[active.attr('flagdown')] = false;
        
        if (active.attr('value')) {
            designer.order.parts[active.attr('key')] = active.attr('value');
        }
        if (active.attr('fabric')) {
            designer.order.fabrics[active.attr('key')] = active.attr('fabric');
        }
    });

    // console.log(designer);

    // designer['cameras'][designer.camera.name]['layers'].map(function(layers, i){
    //     designer.camera.layers[i] = {
    //         layers: layers,
    //         fabrics: designer['cameras'][designer.camera.name]['fabrics'][i]
    //     }
    // });
    
    
    designer.cameras[designer.order.camera].layers.map(function(layer, layerIndex){
        var parts = '', fabrics = '';
        layer.map(function(part, partIndex){
            parts += part + designer.order.parts[part];
            fabrics += designer.cameras[designer.order.camera].fabrics[layerIndex][partIndex]? designer.order.fabrics[designer.parts[part].fabric] : 'F000';
        })
        designer.order.render[layerIndex] = designer.order.camera + '-' + layerIndex + '_' + parts + '_' + fabrics + '.png';        
    });
    
    var imgs = $('.designer-canvas .canvas img');
    
    designer.order.render.map(function(src, i){
        if (imgs[i] == undefined) {
            $('.designer-canvas .canvas').append('<img src="/png/'+ src +'" />');
        }else{
            
            imgs[i].src = "/png/" + src;
            // imgs[i].setAttribute('src', "/png/" + src);// attr('src', src);
        }
    })

    console.log(designer);
    
    
}


    </script>
</body>
</html>