import { getting, putting, posting, setCookie } from "../../helpers";
import routes from '../routes';

export const getComments = () => {
    return (dispatch) => {
        getting(routes('api.comments.index'))
            .then(response => dispatch({
                    type: 'GET-COMMENTS',
                    payload: response.data
            }))
            .catch( error => { console.log(error.response) } );
    }
}