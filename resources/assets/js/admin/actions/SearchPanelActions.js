import { getting, putting, posting, setCookie } from "../../helpers";
import routes from '../routes';

export const setSearchPanel = (id, attributes) => {
    return (dispatch) => {
        dispatch({ type: 'SET-SEARCHPANEL', id, attributes })
    }
}

export const updateSearchPanel = (searchpanel) => {
    return (dispatch) => {
        putting(routes('api.searchpanels.update',[searchpanel.id]), searchpanel.attributes)
            .then(response => dispatch({
                type: 'UPDATE-SEARCHPANEL',
                payload: response.data
            }))
            .catch( error => { console.log(error.response) } );
    }
}

export const getSearchPanels = () => {
    return (dispatch) => {
        getting(routes('api.searchpanels.index'))
            .then(response => dispatch({
                type: 'GET-SEARCHPANELS',
                payload: response.data
            }))
            .catch( error => { console.log(error.response) } );
    }
}