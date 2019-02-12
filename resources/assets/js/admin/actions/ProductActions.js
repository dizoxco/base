import { getting, putting, posting, setCookie } from "../../helpers";
import routes from '../routes';

export const setProduct = (id, attributes) => {
    return (dispatch) => {
        dispatch({ type: 'SET-PRODUCT', id, attributes })
    }
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
            .catch( error => { console.log(error.response) } );
    }
};

export const updateProduct = (product) => {
    return (dispatch) => {
        putting(routes('api.products.update',[product.id]), product.attributes)
            .then(response => dispatch({
                type: 'UPDATE-PRODUCT',
                payload: response.data
            }))
            .catch( error => { console.log(error) } );
    }
};
export const getProducts = () => {
    return (dispatch) => {
        getting(routes('api.products.index'))
            .then(response => dispatch({
                    type: 'GET-PRODUCTS',
                    payload: response.data
            }))
            .catch( error => { console.log(error.response) } );
    }
};