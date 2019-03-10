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
            .catch(response => dispatch({ type: 'ERR', payload: response}));
    }
}

export const addMedia = (media, mediagroup) => {
    return (dispatch) => {
        dispatch({
            type: 'ADD-MEDIAGROUP',
            payload: {media},
            mediagroup
        });
    }
};

export const getMediaGroups = () => {
    return (dispatch) => {
        getting(routes('api.mediagroups.index'))
            .then(response => dispatch({
                    type: 'GET-MEDIAGROUPS',
                    payload: response.data
            }))
            .catch(response => dispatch({ type: 'ERR', payload: response}));
    }
}
