import {deleting, eraseCookie, getting, posting, putting, setCookie} from "../../helpers";
import routes from '../routes';

export const copyUser = (id, callback) => {
    callback();
    return (dispatch) => {
        dispatch({ type: 'COPY-USER', id });
        dispatch({ type: 'SUCCESS', message: 'کاربر در فرم ایجاد رونوشت شد.' })
    }
};

export const deleteUser = (id, callback) => {
    return (dispatch) => {
        deleting(routes('api.users.delete', [id]))
            .then(response => {
                callback();
                dispatch({ type: 'DELETE-USER', id, payload: response.data });
                dispatch({ type: 'SUCCESS', message: 'کاربر با موفقیت به زباله دان انتقال یافت.' });
            })
            .catch(response => dispatch({ type: 'ERR', payload: response}));
    }
};

export const getUsers = () => {
    return (dispatch) => {
        getting(routes('api.users.trash'))
            .then(response => dispatch({type: 'GET-TRASH-USERS', payload: response.data}))
            .catch(response => dispatch({ type: 'ERR', payload: response}));
        getting(routes('api.users.index'))
            .then(response => {
                dispatch({ type: 'GET-USERS', payload: response.data });
                dispatch({ type: 'SUCCESS', message: 'کاربران دریافت شدند' });
            })
            .catch(response => dispatch({ type: 'ERR', payload: response}));
    }
};

export const getToken = (params) => {
    return (dispatch) => {
        posting(routes('api.auth.login'), params)
            .then(response => {
                setCookie('token', response.data.access_token, {});
                return dispatch({
                    type: 'TOKEN',
                    payload: response.data
                });
            })
            .catch(response => dispatch({ type: 'ERR', payload: response}));
    }
};

export const logOut = () =>  {
    eraseCookie('token');
    return (dispatch) => {
        dispatch({ type: 'LOGOUT' });
    }
};

export const resetUser = (id) => {
    return (dispatch) => {
        dispatch({ type: 'RESET-USER', id });
        dispatch({ type: 'SUCCESS', message: 'کاربر به حالت اولیه بازگشت.' })
    }
};

export const restoreUser = (deleted_id) => {
    return (dispatch) => {
        getting(routes('api.users.restore', [deleted_id]))
            .then(response => {
                dispatch({ type: 'RESTORE-USER', deleted_id, payload: response.data });
                dispatch({ type: 'SUCCESS', message: 'کاربر با موفقیت بازیابی شد.' });
            })
            .catch(response => dispatch({ type: 'ERR', payload: response}));
    }
};

export const setUser = (id, attributes) => {
    return (dispatch) => {
        dispatch({ type: 'SET-USER', id, attributes })
    }
};

export const storeUser = (user) => {
    return (dispatch) => {
        posting(routes('api.users.store'), user.attributes)
            .then(response => {
                dispatch({
                    type: 'STORE-USER',
                    payload: response.data
                });

                dispatch({
                    type : 'APP-REDIRECT',
                    payload : '/admin/users/'+response.data.data.id
                });
            })
            .catch(response => dispatch({ type: 'ERR', payload: response}));
    }
};

export const updateUser = (user) => {
    return (dispatch) => {
        putting(routes('api.users.update',[user.id]), user.attributes)
            .then(response => dispatch({
                type: 'UPDATE-USER',
                payload: response.data
            }))
            .catch(response => dispatch({ type: 'ERR', payload: response}));
    }
};