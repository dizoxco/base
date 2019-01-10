const routeslist = {
    api: {
        base: '/api',
        users: {
            base: '/users',
            index: '/index',
            posts: {
                base: '/posts',
                index: '/index',
            }
        }
    }
};

export const routes = (path, params = null) => {
    let result = ''
    var value = path.split('.').reduce(function(a, b) {
        result += ( a[b].base == undefined )? a[b]: a[b].base ; 
        return a[b];
    }, routeslist);

    return result;
}