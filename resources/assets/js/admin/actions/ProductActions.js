import {deleting, getting, posting, putting} from "../../helpers";
import routs from '../routes';

export const copyProduct = (id, callback) => {
    callback();
    return (dispatch) => {
        dispatch({ type: 'COPY-PRODUCT', id });
        dispatch({ type: 'SUCCESS', message: 'محصول در فرم ایجاد رونوشت شد.' })
    }
};

export const deleteProduct = (id, callback) => {
    return (dispatch) => {
        deleting(routs('api.products.delete', [id]))
            .then(response => {
                callback();
                dispatch({ type: 'DELETE-PRODUCT', id, payload: response.data });
                dispatch({ type: 'SUCCESS', message: 'محصول با موفقیت به زباله دان انتقال یافت.' });
            })
            .catch(response => dispatch({ type: 'ERR', payload: response}));
    }
};

export const getProducts = () => {
    return (dispatch) => {
        getting(routs('api.products.trash'))
            .then(response => dispatch({type: 'GET-TRASH-PRODUCTS', payload: response.data}))
            .catch(response => dispatch({ type: 'ERR', payload: response}));
        getting(routs('api.products.index'))
            .then(response => {
                dispatch({ type: 'GET-PRODUCTS', payload: response.data });
                dispatch({ type: 'SUCCESS', message: 'محصولات دریافت شدند' });
            })
            .catch(response => dispatch({ type: 'ERR', payload: response}));
    }
};

export const resetProduct = (id) => {
    return (dispatch) => {
        dispatch({ type: 'RESET-PRODUCT', id });
        dispatch({ type: 'SUCCESS', message: 'محصول به حالت اولیه بازگشت.' })
    }
};

export const restoreProduct = (deleted_id) => {
    return (dispatch) => {
        getting(routs('api.products.restore', [deleted_id]))
            .then(response => {
                dispatch({ type: 'RESTORE-PRODUCT', deleted_id, payload: response.data });
                dispatch({ type: 'SUCCESS', message: 'محصول با موفقیت بازیابی شد.' });
            })
            .catch(response => dispatch({ type: 'ERR', payload: response}));
    }
};

export const setProduct = (id, attributes) => {
    return (dispatch) => {
        dispatch({ type: 'SET-PRODUCT', id, attributes })
    }
};

export const setProductTags = (id, tags, taxonomy_tags) => {
    return (dispatch) => {
        dispatch({ type: 'SET-PRODUCT-TAGS', id, tags, taxonomy_tags })
    }
};

export const storeProduct = (user) => {
    return (dispatch) => {
        posting(routs('api.products.store'), user.attributes)
            .then(response => {
                dispatch({
                    type: 'STORE-PRODUCT',
                    payload: response.data
                });

                dispatch({
                    type : 'APP-REDIRECT',
                    payload : '/admin/products/'+response.data.data.id
                });
            })
            .catch(response => dispatch({ type: 'ERR', payload: response}));
    }
};

export const updateProduct = (user) => {
    return (dispatch) => {
        putting(routs('api.products.update',[user.id]), user.attributes)
            .then(response => dispatch({
                type: 'UPDATE-PRODUCT',
                payload: response.data
            }))
            .catch(response => dispatch({ type: 'ERR', payload: response}));
    }
};