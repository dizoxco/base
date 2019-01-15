import { getting, posting, setCookie } from "../../helpers";
import routes from '../routes';

export const getUsers = () => {
    console.log(routes('api.users.index'));
    
    return (dispatch) => {
        getting(routes('api.users.index'))
            .then(response => {
                console.log(response);
                
                    return dispatch({
                        type: 'GET-USERS',
                        payload: response
                    });
                }
            )
            .catch(error => {
                console.log(error.response);
                
            }
            );
    }
}

export const getToken = (params) => {
    return (dispatch) => {
        posting(routes('api.auth.login'), params)
            .then(response => {
                setCookie('token', response.data.access_token, {});
                return dispatch({
                    type: 'TOKEN',
                    payload: response.data
                });
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