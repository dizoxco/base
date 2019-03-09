import { deleting, getting, putting, posting, setCookie } from "../../helpers";
import routes from '../routes';

export const getPosts = () => {
    return (dispatch) => {
        getting(routes('api.posts.trash'))
            .then(response => dispatch({type: 'GET-TRASH-POSTS', payload: response.data}))
            .catch(response => dispatch({ type: 'ERR', payload: response}));
        getting(routes('api.posts.index'))
            .then(response => {
                dispatch({ type: 'GET-POSTS', payload: response.data })
                dispatch({ type: 'SUCCESS', message: 'مطالب دریافت شد' })
            })
            .catch(response => dispatch({ type: 'ERR', payload: response}));
    }
}

export const setPost = (id, attributes) => {
    return (dispatch) => {
        dispatch({ type: 'SET-POST', id, attributes })
    }
}

export const resetPost = (id) => {
    return (dispatch) => {
        dispatch({ type: 'RESET-POST', id })
        dispatch({ type: 'SUCCESS', message: 'مطلب به حالت اولیه بازگشت.' })
    }
}

export const copyPost = (id, callback) => {
    callback();
    return (dispatch) => {
        dispatch({ type: 'COPY-POST', id })
        dispatch({ type: 'SUCCESS', message: 'مطلب در فرم ایجاد رونوشت شد.' })
    }
}

export const setPostTags = (id, tags, taxonomy_tags) => {
    return (dispatch) => {
        dispatch({ type: 'SET-POST-TAGS', id, tags, taxonomy_tags })
    };
};

export const storePost = (post) => {
    return (dispatch) => {
        posting(routes('api.posts.store'), post.attributes)
            .then(response => {
                dispatch({ type: 'STORE-POST', payload: response.data });
                dispatch({ type: 'SUCCESS', message: 'مطلب با موفقیت ذخیره شد' });
            })
            .catch(response => dispatch({ type: 'ERR', payload: response}));
    }
}

export const updatePost = (post) => {
    return (dispatch) => {
        putting(routes('api.posts.update',[post.id]), {
            ...post.attributes,
            tags: post.relations.tags
        })
            .then(response => {
                dispatch({ type: 'UPDATE-POST', id: post.id, payload: response.data });
                dispatch({ type: 'SUCCESS', message: 'مطلب با موفقیت ذخیره شد' });
            })
            .catch(response => dispatch({ type: 'ERR', payload: response}));
    }
}

export const deletePost = (id, callback) => {
    return (dispatch) => {
        deleting(routes('api.posts.delete', [id]))
            .then(response => {
                callback();
                dispatch({ type: 'DELETE-POST', id, payload: response.data })
                dispatch({ type: 'SUCCESS', message: 'مطلب با موفقیت به زباله دان انتقال یافت.' });
            })
            .catch(response => dispatch({ type: 'ERR', payload: response}));
    }
}

export const restorePost = (deleted_id) => {
    return (dispatch) => {
        getting(routes('api.posts.restore', [deleted_id]))
            .then(response => {
                dispatch({ type: 'RESTORE-POST', deleted_id, payload: response.data });
                dispatch({ type: 'SUCCESS', message: 'مطلب با موفقیت بازیابی شد.' });
            })
            .catch(response => dispatch({ type: 'ERR', payload: response}));
    }
}