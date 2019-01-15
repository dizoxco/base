import { routeMixer } from "../helpers";

const routeslist = {
    api: {
        prefix: '/api',
        auth: {
            prefix: '/auth',
            login: '/login'
        },
        users: {
            prefix: '/users',
            index: '',
            posts: {
                prefix: '/posts',
                index: '/index',
            },
            show: '/{user}/show',
            edit: '/{user}/edit',
        },
    }
};

export default (path, params = null) => {
    return routeMixer(routeslist, path, params);
}