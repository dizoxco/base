import { routeMixer } from "../helpers";

const routeslist = {
    api: {
        prefix: '/api',
        auth: {
            prefix: '/auth',
            login: '/login'
        },
        businesses: {
            prefix: '/businesses',
            index: ''
        },
        posts: {
            prefix: '/posts',
            index: '',
            show: '/{post}',
            update: '/{post}'
        },
        products: {
            prefix: '/users',
            index: '',
        },
        users: {
            prefix: '/users',
            index: '',
            posts: {
                prefix: '/posts',
                index: '/index',
            },
            show: '/{user}',
            edit: '/{user}/edit',
        },
    }
};

export default (path, params = null) => {
    return routeMixer(routeslist, path, params);
}