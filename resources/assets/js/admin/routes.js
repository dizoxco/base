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
            store: '',
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
        tags: {
            prefix: '/tags',
            index: '',
            show: '/{tag}',
            update: '/{tag}'
        },
        taxonomies: {
            prefix: '/taxonomies',
            index: '?include=tags',
        },
        products: {
            prefix: '/products',
            index: '',
            store: '',
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
            store: '',
            show: '/{user}',
            edit: '/{user}/edit',
            update: '/{user}'
        },
    }
};

export default (path, params = null) => {
    return routeMixer(routeslist, path, params);
}