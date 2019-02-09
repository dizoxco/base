import mdcAutoInit from '@material/auto-init';
import {MDCTextField} from '@material/textfield';
import {MDCTextFieldIcon} from '@material/textfield/icon';
import {MDCRipple} from '@material/ripple';

// const buttonRipple = new MDCRipple(document.querySelector('.mdc-button'));


// const buttonRipple = new MDCRipple(document.querySelector('.mdc-button'));
// rrr.handleFocus();
// MDCRipple.attachTo(document.querySelector('.omid'));

// const buttonRipple = new MDCRipple(document.querySelector('.mdc-button'));
// mdcAutoInit.register('mdc-ripple', MDCRipple);
// MDCRipple.attachTo(document.querySelector('.mdc-button'));

mdcAutoInit.register('mdc-text-field', MDCTextField);
mdcAutoInit.register('mdc-text-field-icon', MDCTextFieldIcon);
mdcAutoInit.register('mdc-ripple', MDCRipple);
mdcAutoInit();
