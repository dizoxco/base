import { getting, putting, posting, setCookie } from "../../helpers";
import routes from '../routes';

export const getMediaGroups = () => {
    return (dispatch) => {
        getting(routes('api.mediagroups.index'))
            .then(response => dispatch({
                    type: 'GET-MEDIAGROUPS',
                    payload: response.data
            }))
            .catch( error => { console.log(error.response) } );
    }
}