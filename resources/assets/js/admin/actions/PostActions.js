import { getting, posting, setCookie } from "../../helpers";
import routes from '../routes';

export const increment = () => dispatch => {
    dispatch({ type: 'INCREMENT' });
};

export const setPost = (id, attributes) => {
    return (dispatch) => {
        dispatch({ type: 'SET-POST', id, attributes })
    }
}

export const getPosts = () => {
    return (dispatch) => {
        getting(routes('api.posts.index'))
            .then(response => dispatch({
                type: 'GET-POSTS',
                payload: response.data
            }))
            .catch( error => { console.log(error.response) } );
    }
}