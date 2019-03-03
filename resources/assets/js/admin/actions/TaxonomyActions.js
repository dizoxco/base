import routes from '../routes';
import {getting, posting, putting} from "../../helpers";

export const getTaxonomies = () => {
    return (dispatch) => {
        getting(routes('api.taxonomies.index'))
            .then(response =>{dispatch({
                type: 'GET-TAXONOMIES',
                payload: response.data
            })})
            .catch(response => dispatch({ type: 'ERR', payload: response}));
    }
};

export const storeTaxonomy = (taxonomy, callback) => {
    return (dispatch) => {
        posting(routes('api.taxonomies.store'), taxonomy.attributes)
            .then((response) => {
                callback();
                return dispatch({
                    type: 'STORE-TAXONOMIES',
                    payload: response.data
                })
            })
            .catch(response => dispatch({ type: 'ERR', payload: response}));
    };
};

export const setTaxonomy = (id, attributes) => {
    return (dispatch) => {
        dispatch({ type: 'SET-TAXONOMIES', id, attributes })
    };
};

export const updateTaxonomy = (taxonomy, callback) => {
    return (dispatch) => {
        putting(routes('api.taxonomies.update',[taxonomy.id]), taxonomy.attributes)
            .then((response) => {
                callback();
                return dispatch({
                    type: 'UPDATE-TAXONOMIES',
                    payload: response.data
                })
            })
            .catch(response => dispatch({ type: 'ERR', payload: response}));
    };
};