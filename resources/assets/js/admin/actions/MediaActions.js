import { getting, putting, posting, setCookie } from "../../helpers";
import routes from '../routes';

export const getMediaGroup = (mediagroup) => {
    return (dispatch) => {
        getting(routes('api.mediagroups.show', [mediagroup]))
            .then(response => dispatch({
                    type: 'GET-MEDIAGROUP',
                    payload: response.data,
                    mediagroup
            }))
            .catch( error => { console.log(error.response) } );
    }
}

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
