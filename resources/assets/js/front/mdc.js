import mdcAutoInit from '@material/auto-init';
import {MDCTextField} from '@material/textfield';
import {MDCTextFieldIcon} from '@material/textfield/icon';
import {MDCRipple} from '@material/ripple';
import {MDCSelect} from '@material/select';
import {MDCList} from '@material/list';
import {MDCDialog} from '@material/dialog';

// import {MDCTabBar} from '@material/tab-bar';
// const tabBar = new MDCTabBar(document.querySelector('.mdc-tab-bar'));
// console.log('dddddddd');


window.mdc = {autoInit: mdcAutoInit};

mdcAutoInit.register('mdc-text-field', MDCTextField);
// mdcAutoInit.register('mdc-list', MDCList);
mdcAutoInit.register('mdc-text-field-icon', MDCTextFieldIcon);
mdcAutoInit.register('mdc-ripple', MDCRipple);
$('.mdc-select').each(function(index){
    new MDCSelect($(this)[0]    );
})
var dialogs = [];
$('.mdc-dialog').each(function(index){
    dialogs[$(this).attr('id')] = new MDCDialog($(this)[0]);
})
$('[dialog]').click(function(){
    dialogs[$(this).attr('dialog')].open();
});

// const list = new MDCList(document.querySelector('.mdc-list'));
// const listItemRipples = list.listElements.map((listItemEl) => new MDCRipple(listItemEl));

mdcAutoInit();