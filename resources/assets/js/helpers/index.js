export {getting, posting}from './network';
export {getCookie, setCookie} from './cookie';
export const routeMixer = (routeslist, path, prams=null) => {
    let result = ''
    path.split('.').reduce(function(a, b) {
        result += ( a[b].prefix == undefined )? a[b]: a[b].prefix ; 
        return a[b];
    }, routeslist);

    return result;
}