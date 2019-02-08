// import $ from 'jquery';
import Swiper from 'swiper';
window.$ = window.jQuery = require("jquery");

if ($('.product-gallery').length) {

    var productGalleryIndex = 0;
    var productGallery = new Swiper('.product-gallery .swiper', {
        speed: 400,
        spaceBetween: 0,
        direction: 'vertical',
        slidesPerView: 4,
        releaseOnEdges: true,
        autoplay: false,
        loop: false,
        mousewheel: true,
    });

    $('.product-image').click(function(){
        $('body').addClass('overflow-hidden');
        $('.product-gallery').toggleClass('fixed hidden flex');
        productGallery.update();
        productGalleryShow(0);
    });
    $('.product-images .swiper-slide').click(function(){
        $('body').addClass('overflow-hidden');
        $('.product-gallery').toggleClass('fixed hidden flex');
        productGallery.update();
        productGalleryShow(1+$(this).index());
    });
    $('.product-gallery .close').click(function(){
        $('body').removeClass('overflow-hidden');
        $('.product-gallery').toggleClass('fixed hidden flex');
    });
    $('.product-gallery .prev').click(function(){
        if (productGalleryIndex > 0) {
            productGalleryShow(productGalleryIndex -1);
        }
    });
    $('.product-gallery .next').click(function(){
        if (productGalleryIndex < productGallery.slides.length-1){
            productGalleryShow(productGalleryIndex + 1);
        }
    });
    $('.product-gallery .swiper-slide').click(function(){
        productGalleryShow( $(this).index() );
    });

    function productGalleryShow(index){
        productGalleryIndex = index;
        productGallery.slideTo(index);
        $('.product-gallery .banner').html( $('.product-gallery .swiper img').clone()[index] );
    }
}

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


import mdcAutoInit from '@material/auto-init';
import {MDCTextField} from '@material/textfield';
import {MDCTextFieldIcon} from '@material/textfield/icon';
import {MDCRipple} from '@material/ripple';

mdcAutoInit.register('mdc-text-field', MDCTextField);
mdcAutoInit.register('mdc-text-field-icon', MDCTextFieldIcon);

// const buttonRipple = new MDCRipple(document.querySelector('.mdc-button'));


// const buttonRipple = new MDCRipple(document.querySelector('.mdc-button'));
// rrr.handleFocus();
// MDCRipple.attachTo(document.querySelector('.omid'));

// const buttonRipple = new MDCRipple(document.querySelector('.mdc-button'));
// mdcAutoInit.register('mdc-ripple', MDCRipple);
MDCRipple.attachTo(document.querySelector('.mdc-button'));
mdcAutoInit();

$('.toggler').click(function(){
    console.log('dd');
    
    $($(this).attr('toggle-target')).toggleClass($(this).attr('toggle-class'));
});