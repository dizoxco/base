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
            index: '',
            update: '/{business}'
        },
        comments: {
            prefix: '/comments',
            index: ''
        },
        mediagroups: {
            prefix: '/mediagroups',
            index: '',
            show: '/{mediagroup}',
            store: '/{mediagroup}'
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
            update: '/{product}'
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
            update: '/{user}'
        },
    }
};

export default (path, params = null) => {
    return routeMixer(routeslist, path, params);
}