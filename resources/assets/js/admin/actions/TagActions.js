import {getting, putting} from "../../helpers";
import routes from '../routes';

export const getTags = () => {
    return (dispatch) => {
        getting(routes('api.tags.index'))
            .then(response => dispatch({
                type: 'GET-TAGS',
                payload: response.data
            }))
            .catch( error => { console.log(error.response) } );
    }
}

export const updateTag = post => {
    return (dispatch) => {
        putting(routes('api.tags.update',[post.id]), post.attributes)
            .then(response => dispatch({
                type: 'UPDATE-TAG',
                payload: response.data
            }))
            .catch( error => { console.log(error.response) } );
    }
};