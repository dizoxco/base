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
            trash: '/trash',
            show: '/{post}',
            update: '/{post}',
            delete: '/{post}',
            store: '',
            restore: '/{post}/restore'
        },
        tags: {
            prefix: '/tags',
            index: '',
            store: '',
            update: '/{tag}'
        },
        taxonomies: {
            prefix: '/taxonomies',
            index: '?include=tags',
            store: '',
            update: '/{post}',
        },
        products: {
            prefix: '/products',
            index: '?include=tags',
            show: '/{product}',
            store: '',
            update: '/{product}',
            delete: '/{product}',
        },
        searchpanels: {
            prefix: '/searchpanels',
            index: '',
            show: '/{searchpanel}',
            update: '/{searchpanel}',
            store: ''
        },
        tickets: {
            prefix: '/tickets',
            index: '',
        },
        users: {
            prefix: '/users',
            index: '',
            trash: '/trash',
            posts: {
                prefix: '/posts',
                index: '/index',
            },
            store: '',
            restore: '/{user}/restore',
            show: '/{user}',
            edit: '/{user}/edit',
            update: '/{user}',
            delete: '/{product}',
        },
    }
};

export default (path, params = null) => {
    return routeMixer(routeslist, path, params);
}