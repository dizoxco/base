import { getting, putting, posting, setCookie } from "../../helpers";
import routes from '../routes';
    

export const getSearchPanels = () => {
    return (dispatch) => {
        getting(routes('api.searchpanels.index'))
            .then(response => dispatch({
                type: 'GET-SEARCHPANELS',
                payload: response.data
            }))
            .catch(response => dispatch({ type: 'ERR', payload: response}));
    }
}

export const setSearchPanel = (id, attributes) => {
    return (dispatch) => {
        dispatch({ type: 'SET-SEARCHPANEL', id, attributes })
    }
}

export const storeSearchPanel = (searchpanel) => {
    return (dispatch) => {
        posting(routes('api.searchpanels.store'), searchpanel.attributes)
            .then(response => dispatch({
                type: 'STORE-SEARCHPANEL',
                payload: response.data
                // searchpanel
            }))
            .catch(response => dispatch({ type: 'ERR', payload: response}));
    }
} 

export const updateSearchPanel = (searchpanel) => {
    return (dispatch) => {
        putting(routes('api.searchpanels.update',[searchpanel.id]), searchpanel.attributes)
            .then(response => dispatch({
                type: 'UPDATE-SEARCHPANEL',
                searchpanel
            }))
            .catch(response => dispatch({ type: 'ERR', payload: response}));
    }
}