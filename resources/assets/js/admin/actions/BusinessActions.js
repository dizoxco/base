import {deleting, getting, posting, putting} from "../../helpers";
import routes from '../routes';

export const copyBusiness = (id, callback) => {
    callback();
    return (dispatch) => {
        dispatch({ type: 'COPY-BUSINESS', id });
        dispatch({ type: 'SUCCESS', message: 'کسب و کار در فرم ایجاد رونوشت شد.' })
    }
};

export const deleteBusiness = (id, callback) => {
    return (dispatch) => {
        deleting(routes('api.businesses.delete', [id]))
            .then(response => {
                callback();
                dispatch({ type: 'DELETE-BUSINESS', id, payload: response.data });
                dispatch({ type: 'SUCCESS', message: 'کسب و کار با موفقیت به زباله دان انتقال یافت.' });
            })
            .catch(response => dispatch({ type: 'ERR', payload: response}));
    }
};

export const getBusinesses = () => {
    return (dispatch) => {
        getting(routes('api.businesses.trash'))
            .then(response => dispatch({type: 'GET-TRASH-BUSINESSES', payload: response.data}))
            .catch(response => dispatch({ type: 'ERR', payload: response}));
        getting(routes('api.businesses.index'))
            .then(response => {
                dispatch({ type: 'GET-BUSINESSES', payload: response.data });
                dispatch({ type: 'SUCCESS', message: 'کسب و کارها دریافت شدند' });
            })
            .catch(response => dispatch({ type: 'ERR', payload: response}));
    }
};

export const resetBusiness = (id) => {
    return (dispatch) => {
        dispatch({ type: 'RESET-BUSINESS', id });
        dispatch({ type: 'SUCCESS', message: 'کسب و کار به حالت اولیه بازگشت.' })
    }
};

export const restoreBusiness = (deleted_id) => {
    return (dispatch) => {
        getting(routes('api.businesses.restore', [deleted_id]))
            .then(response => {
                dispatch({ type: 'RESTORE-BUSINESS', deleted_id, payload: response.data });
                dispatch({ type: 'SUCCESS', message: 'کسب و کار با موفقیت بازیابی شد.' });
            })
            .catch(response => dispatch({ type: 'ERR', payload: response}));
    }
};

export const setBusiness = (id, attributes) => {
    return (dispatch) => {
        dispatch({ type: 'SET-BUSINESS', id, attributes })
    }
};

export const storeBusiness = (user) => {
    return (dispatch) => {
        posting(routes('api.businesses.store'), user.attributes)
            .then(response => {
                dispatch({
                    type: 'STORE-BUSINESS',
                    payload: response.data
                });

                dispatch({
                    type : 'APP-REDIRECT',
                    payload : '/admin/businesses/'+response.data.data.id
                });
            })
            .catch(response => dispatch({ type: 'ERR', payload: response}));
    }
};

export const updateBusiness = (user) => {
    return (dispatch) => {
        putting(routes('api.businesses.update',[user.id]), user.attributes)
            .then(response => dispatch({
                type: 'UPDATE-BUSINESS',
                payload: response.data
            }))
            .catch(response => dispatch({ type: 'ERR', payload: response}));
    }
};