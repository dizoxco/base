export const routeMixer = (routeslist, path, params=null) => {
    let url = ''
    path.split('.').reduce(function(a, b) {
        url += ( a[b].prefix == undefined )? a[b]: a[b].prefix ; 
        return a[b];
    }, routeslist);

    if (Array.isArray(params)) {
        let keys = url.match(/\{.*?\}/g);
        
        if (keys === null || keys === undefined) {
            return url    
        }

        if (keys.length !== params.length) {
            throw new Error('Expected route bindValues are not equal.');
        }

        for (let i = 0; i < keys.length; i++) {
            url = url.replace(keys[i], params[i]);
        }        
    }

    return url;
}