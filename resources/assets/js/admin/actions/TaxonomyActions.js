import {getting} from "../../helpers";
import routes from '../routes';

export const getTaxonomies = () => {
    return (dispatch) => {
        getting(routes('api.taxonomies.index'))
            .then(response =>{console.log(response); dispatch({
                type: 'GET-TAXONOMIES',
                payload: response.data
            })})
            .catch( error => { console.log(error.response) } );
    }
};