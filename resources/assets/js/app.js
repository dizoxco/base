// import $ from 'jquery';
import Swiper from 'swiper';
import Sortable from 'sortablejs';
window.$ = window.jQuery = require("jquery");
require("./front/productGallery");
require("./front/mdc");
require("./front/navigation");

// table collapsible
$('.collapse').click(function(){
    $(this).next().toggleClass('hidden');
    if($(this).next().hasClass('hidden')){
        $(this).find('i').html('expand_more')
    } else {
        $(this).find('i').html('expand_less')
    }
    
});


// filter collapsible


  
$('.scroll-swiper').each(function(){
    new Swiper($(this), {
        direction: 'vertical',
        slidesPerView: 'auto',
        freeMode: true,
        scrollbar: {
        el: '.swiper-scrollbar',
        },
        mousewheel: true,
    });
});
$('.swiper.simple').each(function(){
    new Swiper($(this), {
        speed: 400,
        spaceBetween: 0,
        direction: $(this).attr('direction')? $(this).attr('direction'): 'horizontal',
        mousewheel: $(this).attr('direction') == 'vertical',
        slidesPerView: $(this).attr('column'),
        autoplay: true,
        loop: false,
    });
});

$('.toggler').click(function(){
    console.log('dd');
    
    $($(this).attr('toggle-target')).toggleClass($(this).attr('toggle-class'));
});


$('.search-panel-options input').change(function(e){
    e.preventDefault();
    var url = window.location.href.split('?')[0] + '?';
    $('.search-panel-options input').each(function(){
        switch ($(this).attr('type')) {
            case 'checkbox':
                if ($(this).is(':checked')) {
                    url += $(this).attr('name') + '=' + $(this).val() + '&'
                }
                break;
            default:
                if ($(this).val()) {
                    url += $(this).attr('name') + '=' + $(this).val() + '&'
                }
                break;
        }
    })
    // ajaxUpdate(url, '.search-panel-result');
    
    $.get( url, function( data ) {
        $( '.search-panel-result' ).html( $(data).find('.search-panel-result').html() );
        window.history.pushState({}, '', url);
    }, 'html')
})

$('td').click(function(){
    if( $(this).parent().attr('href') ){
        window.location = $(this).parent().attr('href');
    }
});


$('a.chat-id').click(function(e){
    e.preventDefault();
    $.get( $(this).attr('api-href'), function( data ) {
        $( '.chat-comments' ).html( $(data).find('.chat-comments').html() );
        new Swiper($('.chat-comments .scroll-swiper'), {
            direction: 'vertical',
            slidesPerView: 'auto',
            freeMode: true,
            scrollbar: {
                el: '.swiper-scrollbar',
            },
            mousewheel: true,
        });
        window.mdc.autoInit(document.querySelector('.chat-comments'));
    }, 'html');
});




if($('#product-options').length){
    var productOptions = {};
    productPageUpdate();
    function productPageUpdate(){
        $('#product-options [option]').each(function(){
            productOptions[$(this).attr('option')] = $(this).find('.check.active').length? 
                        $(this).find('.check.active').attr('value'):
                        $(this).find('.check').first().attr('value');
        });
        $('table.product-variations tr').each(function(){
            var show = true;
            for (var key in productOptions) {
                if(productOptions[key] != $(this).attr(key) )
                    show = false
            }
            if (show) {
                $(this).removeClass('hidden');
            }else{
                $(this).addClass('hidden');
            }
        });
        
    }
    $('#product-options .check').click(function(){
        $(this).parent().find('.check.active').removeClass('active');
        $(this).addClass('active');
        productPageUpdate();
    });
}




$('.mdc-select__selected-text').click(function(){
    $('.mdc-select__menu').width($(this).parent().width());
});





$(document).ready(function () {
    gapi.load('auth2', function() {
        gapi.auth2.init();
    });

    function onSignIn(googleUser) {
        var xhr;
        var id_token = googleUser.getAuthResponse().id_token;
        xhr = new XMLHttpRequest();
        xhr.open('POST', '/google');
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.setRequestHeader('X-CSRF-Token', $('meta[name="X-CSRF-Token"]').attr('content'));
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

    $('#btn_side_login').click(function (event) {
        event.preventDefault();
        $.post( "/api/auth/login", {
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
        $.post( "/api/auth/register", {
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
});


$('.addable .add').click(function(){
    $(this).prev().prev().append($(this).prev().html());
    window.mdc.autoInit();
});

// var el = document.querySelector('.addable .items');
// var sortable = Sortable.create(el);

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

