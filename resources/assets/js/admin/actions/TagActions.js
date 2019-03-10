import routes from '../routes';
import {deleting, getting, posting, putting} from "../../helpers";

export const getTags = () => {
    return (dispatch) => {
        getting(routes('api.tags.index'))
            .then(response => dispatch({
                type: 'GET-TAGS',
                payload: response.data
            }))
            .catch(response => dispatch({ type: 'ERR', payload: response}));
    }
};

export const storeTag = (tag, callback) => {
    return (dispatch) => {
        posting(routes('api.tags.store'), tag.attributes)
            // .then((response) => {
            //     callback();
            //     return dispatch({
            //         type: 'STORE-TAG',
            //         payload: response.data
            //     })
            // })
            .then((response) => {
                callback();
                dispatch({ type: 'STORE-TAG', payload: response.data });
                dispatch({ type: 'SUCCESS', message: 'تگ با موفقیت ذخیره شد' });
            })
            .catch(response => dispatch({ type: 'ERR', payload: response}));
    };
};

export const setTag = (id, attributes) => {
    return (dispatch) => {
        dispatch({ type: 'SET-TAG', id, attributes })
    }
};

export const updateTag = (tag, callback) => {
    return (dispatch) => {
        putting(routes('api.tags.update',[tag.id]), tag.attributes)
            // .then((response) => {
            //     callback();
            //     return dispatch({
            //         type: 'UPDATE-TAG',
            //         payload: response.data
            //     })
            // })
            .then(response => {
                dispatch({ type: 'UPDATE-TAG', id: tag.id, payload: response.data });
                dispatch({ type: 'SUCCESS', message: 'تگ با موفقیت ذخیره شد' });
            })
            .catch(response => dispatch({ type: 'ERR', payload: response}));
    };
};
export const resetTag = (id) => {
    return (dispatch) => {
        dispatch({ type: 'RESET-TAG ', id })
        dispatch({ type: 'SUCCESS', message: 'تگ به حالت اولیه بازگشت.' })
    }
}

export const copyTag = (id, callback) => {
    callback();
    return (dispatch) => {
        dispatch({ type: 'COPY-TAG', id })
        dispatch({ type: 'SUCCESS', message: 'تگ در فرم ایجاد رونوشت شد.' })
    }
}
export const deleteTag = (id, callback) => {
    return (dispatch) => {
        deleting(routes('api.tags.delete', [id]))
            .then(response => {
                callback();
                dispatch({ type: 'DELETE-TAG', id, payload: response.data })
                dispatch({ type: 'SUCCESS', message: 'تگ با موفقیت به زباله دان انتقال یافت.' });
            })
            .catch(response => dispatch({ type: 'ERR', payload: response}));
    }
}

export const restoreTag = (deleted_id) => {
    return (dispatch) => {
        getting(routes('api.tags.restore', [deleted_id]))
            .then(response => {
                dispatch({ type: 'RESTORE-TAG', deleted_id, payload: response.data });
                dispatch({ type: 'SUCCESS', message: 'تگ با موفقیت بازیابی شد.' });
            })
            .catch(response => dispatch({ type: 'ERR', payload: response}));
    }
}
