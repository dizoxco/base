import mdcAutoInit from '@material/auto-init';
import {MDCTextField} from '@material/textfield';
import {MDCTextFieldIcon} from '@material/textfield/icon';
import {MDCRipple} from '@material/ripple';
import {MDCSelect} from '@material/select';

mdcAutoInit.register('mdc-text-field', MDCTextField);
mdcAutoInit.register('mdc-text-field-icon', MDCTextFieldIcon);
mdcAutoInit.register('mdc-ripple', MDCRipple);
$('.mdc-select').each(function(index){
    const select = new MDCSelect($(this)[0]    );
})
mdcAutoInit();
