import $ from 'jquery';
import Swiper from 'swiper';

$('.swiper.simple').each(function(){
    new Swiper($(this), {
        speed: 400,
        spaceBetween: 0,
        slidesPerView: $(this).attr('column'),
        autoplay: true,
        loop: true
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