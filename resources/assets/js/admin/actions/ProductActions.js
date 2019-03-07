import {deleting, getting, posting, putting} from "../../helpers";
import routes from '../routes';

export const getProducts = () => {
    return (dispatch) => {
        getting(routes('api.products.index'))
            .then(response => dispatch({
                type: 'GET-PRODUCTS',
                payload: response.data
            }))
            .catch(response => dispatch({ type: 'ERR', payload: response}));
    };
};

export const setProduct = (id, attributes) => {
    return (dispatch) => {
        dispatch({ type: 'SET-PRODUCT', id, attributes })
    }
};

export const resetProduct = (id) => {
    return (dispatch) => {
        dispatch({ type: 'RESET-PRODUCT', id })
    }
};

export const copyProduct = (id, callback) => {
    callback();
    return (dispatch) => {
        dispatch({ type: 'COPY-PRODUCT', id })
    }
};

export const setProductTags = (id, tags, taxonomy_tags) => {
    return (dispatch) => {
        dispatch({ type: 'SET-PRODUCT-TAGS', id, tags, taxonomy_tags })
    };
};

export const storeProduct = (product) => {
    return (dispatch) => {
        posting(routes('api.products.store'), product.attributes)
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
    };
};

export const updateProduct = (product) => {
    return (dispatch) => {
        putting(routes('api.products.update',[product.id]), {
            ...product.attributes,
            tags: product.relations.tags
        })
            .then(response => dispatch({
                type: 'UPDATE-PRODUCT',
                payload: response.data
            }))
            .catch(response => dispatch({ type: 'ERR', payload: response}));
    };
};

export const deleteProduct = (id, callback) => {
    return (dispatch) => {
        deleting(routes('api.products.delete', [id]))
            .then(response => {
                callback();
                return dispatch({ type: 'DELETE-PRODUCT', id, payload: response.data })
            })
            .catch(response => dispatch({ type: 'ERR', payload: response}));
    }
};
