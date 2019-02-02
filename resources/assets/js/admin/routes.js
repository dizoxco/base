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
        comments: {
            prefix: '/comments',
            index: ''
        },
        posts: {
            prefix: '/posts',
            index: '?include=banner',
            show: '/{post}',
            update: '/{post}'
        },
        products: {
            prefix: '/products',
            index: '',
        },
        tickets: {
            prefix: '/tickets',
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