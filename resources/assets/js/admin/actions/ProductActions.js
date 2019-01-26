import { getting, putting, posting, setCookie } from "../../helpers";
import routes from '../routes';

export const getProducts = () => {
    return (dispatch) => {
        getting(routes('api.products.index'))
            .then(response => dispatch({
                    type: 'GET-PRODUCTS',
                    payload: response.data
            }))
            .catch( error => { console.log(error.response) } );
    }
}