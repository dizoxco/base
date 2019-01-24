import { getting, posting, setCookie } from "../../helpers";
import routes from '../routes';

export const getUsers = () => {
    return (dispatch) => {
        getting(routes('api.users.index'))
            .then(response => dispatch({
                type: 'GET-USERS',
                payload: response.data
            }))
            .catch( error => { console.log(error.response) });
    }
}

export const getToken = (params) => {
    return (dispatch) => {
        posting(routes('api.auth.login'), params)
            .then(response => {
                setCookie('token', response.data.access_token, {});
                // return dispatch({
                //     type: 'TOKEN',
                //     payload: response.data
                // });
            })
            .catch(error => dispatch({
                    type: 'SNACKS-ERROR',
                    payload: error.response.data.errors
                })
            );
    }
};

export const logOut = () => dispatch => {
    dispatch({ type: 'LOGOUT' });
};