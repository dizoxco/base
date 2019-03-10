import {getting} from "../../helpers";
import routes from '../routes';

export const getCities = () => {
    return (dispatch) => {
        getting(routes('api.cities.index'))
            .then(response => {
                dispatch({ type: 'GET-CITIES', payload: response.data });
                dispatch({ type: 'SUCCESS', message: 'شهرها دریافت شدند' });
            })
            .catch(response => dispatch({ type: 'ERR', payload: response}));
    }
};