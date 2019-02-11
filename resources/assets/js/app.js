// import $ from 'jquery';
import Swiper from 'swiper';
window.$ = window.jQuery = require("jquery");
require("./front/productGallery");
require("./front/mdc");
require("./front/navigation");

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