import { getting, putting, posting, setCookie } from "../../helpers";
import routes from '../routes';

export const getTickets = () => {
    return (dispatch) => {
        getting(routes('api.tickets.index'))
            .then(response => dispatch({
                    type: 'GET-TICKETS',
                    payload: response.data
            }))
            .catch( error => { console.log(error.response) } );
    }
}