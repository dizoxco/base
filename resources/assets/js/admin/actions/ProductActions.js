import { getting, putting, posting, setCookie } from "../../helpers";
import routes from '../routes';

export const setProduct = (id, attributes) => {
    return (dispatch) => {
        dispatch({ type: 'SET-PRODUCT', id, attributes })
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