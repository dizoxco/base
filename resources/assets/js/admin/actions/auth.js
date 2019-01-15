import { posting } from "../../utilities/helpers";
import routes from '../routes';

export const getToken = (params) => {
    return (dispatch) => {
        posting(routes('api.auth.login'), params)
            .then(response => dispatch({
                    type: 'TOKEN',
                    payload: response.data
                })
            )
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