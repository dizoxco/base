import mdcAutoInit from '@material/auto-init';
import {MDCTextField} from '@material/textfield';
import {MDCTextFieldIcon} from '@material/textfield/icon';
import {MDCRipple} from '@material/ripple';
import {MDCSelect} from '@material/select';
import {MDCList} from '@material/list';

window.mdc = {autoInit: mdcAutoInit};

mdcAutoInit.register('mdc-text-field', MDCTextField);
// mdcAutoInit.register('mdc-list', MDCList);
mdcAutoInit.register('mdc-text-field-icon', MDCTextFieldIcon);
mdcAutoInit.register('mdc-ripple', MDCRipple);
$('.mdc-select').each(function(index){
    const select = new MDCSelect($(this)[0]    );
})


const list = new MDCList(document.querySelector('.mdc-list'));
const listItemRipples = list.listElements.map((listItemEl) => new MDCRipple(listItemEl));

mdcAutoInit();
