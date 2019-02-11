import {eraseCookie, getting, posting, putting, setCookie} from "../../helpers";
import routes from '../routes';


export const setUser = (id, attributes) => {
    return (dispatch) => {
        dispatch({ type: 'SET-USER', id, attributes })
    }
};

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
export const updateUser = (user) => {
    return (dispatch) => {
        putting(routes('api.users.update',[user.id]), user.attributes)
            .then(response => dispatch({
                type: 'UPDATE-USER',
                payload: response.data
            }))
            .catch( error => { console.log(error) } );
    }
};

export const storeUser = (user) => {
    return (dispatch) => {
        posting(routes('api.users.store'), user.attributes)
            .then(response => {
                dispatch({
                    type: 'STORE-USER',
                    payload: response.data
                });

                dispatch({
                    type : 'APP-REDIRECT',
                    payload : '/admin/users/'+response.data.data.id
                });


            })
            .catch( error => { console.log(error.response) } );
    }
};

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

export const logOut = () =>  {
    eraseCookie('token');
    return (dispatch) => {
        dispatch({ type: 'LOGOUT' });
    }
};