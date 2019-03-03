import routes from '../routes';
import {getting, posting, putting} from "../../helpers";

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
            .then((response) => {
                callback();
                return dispatch({
                    type: 'STORE-TAG',
                    payload: response.data
                })
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
            .then((response) => {
                callback();
                return dispatch({
                    type: 'UPDATE-TAG',
                    payload: response.data
                })
            })
            .catch(response => dispatch({ type: 'ERR', payload: response}));
    };
};
