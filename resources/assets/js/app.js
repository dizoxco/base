// import $ from 'jquery';
import Swiper from 'swiper';
window.$ = window.jQuery = require("jquery");

if ($('.product-gallery').length) {
    

    var productGalleryIndex = 0;
    var productGalleryCount = $('.product-gallery .swiper-slide').length;
    var productGallery = new Swiper('.product-gallery .swiper', {
        speed: 400,
        spaceBetween: 0,
        direction: 'vertical',
        slidesPerView: 4,
        autoplay: false,
        loop: false
    });

    $('.product-gallery .prev').click(function(){
        if (productGalleryIndex > 0) {
            productGalleryIndex--; 
            productGallery.slidePrev();
            productGalleryUpdate();
        }
    });
    $('.product-gallery .next').click(function(){
        if (productGalleryIndex < productGalleryCount-1){
            productGallery.slideNext();
            productGalleryIndex++;
            productGalleryUpdate();
        }
    });
    $('.product-gallery .swiper-slide').click(function(){
        productGalleryIndex = $(this).index();
        productGalleryUpdate();
    });
    jQuery('.product-gallery .swiper').on('mousewheel DOMMouseScroll', function(e) {
        if (e.originalEvent.wheelDelta > 0 || e.originalEvent.detail < 0) {
            // if (topThumb > 0) thumbsMoveUp(1);
            productGallery.slidePrev();
        } else {
            productGallery.slideNext();
            // if (topThumb < (thumbsCount - 5)) thumbsMoveDown(1);
        }
    });
    function productGalleryUpdate(){
        $('.product-gallery .banner').html( $('.product-gallery .swiper img').clone()[productGalleryIndex] );
    }
}

$('.swiper.simple').each(function(){
    new Swiper($(this), {
        speed: 400,
        spaceBetween: 0,
        direction: $(this).attr('direction')? $(this).attr('direction'): 'horizontal',
        slidesPerView: $(this).attr('column'),
        autoplay: true,
        loop: false
    });
});


import mdcAutoInit from '@material/auto-init';
import {MDCTextField} from '@material/textfield';
import {MDCTextFieldIcon} from '@material/textfield/icon';
// import {MDCRipple} from '@material/ripple';

mdcAutoInit.register('mdc-text-field', MDCTextField);
mdcAutoInit.register('mdc-text-field-icon', MDCTextFieldIcon);

// const buttonRipple = new MDCRipple(document.querySelector('.mdc-button'));


// const buttonRipple = new MDCRipple(document.querySelector('.mdc-button'));
// rrr.handleFocus();
// MDCRipple.attachTo(document.querySelector('.omid'));

// const buttonRipple = new MDCRipple(document.querySelector('.mdc-button'));
// mdcAutoInit.register('mdc-ripple', MDCRipple);
// MDCRipple.attachTo(document.querySelector('.mdc-button'));
mdcAutoInit();

$('.toggler').click(function(){
    console.log('dd');
    
    $($(this).attr('toggle-target')).toggleClass($(this).attr('toggle-class'));
});