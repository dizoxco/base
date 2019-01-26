import { getting, putting, posting, setCookie } from "../../helpers";
import routes from '../routes';

export const getBusinesses = () => {
    return (dispatch) => {
        getting(routes('api.businesses.index'))
            .then(response => dispatch({
                    type: 'GET-BUSINESSES',
                    payload: response.data
            }))
            .catch( error => { console.log(error.response) } );
    }
}