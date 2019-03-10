import { deleting, getting, putting, posting, setCookie } from "../../helpers";
import routes from '../routes';
    

export const getSearchPanels = () => {
    return (dispatch) => {
        getting(routes('api.searchpanels.trash'))
            .then(response => dispatch({type: 'GET-TRASH-SEARCHPANELS', payload: response.data}))
            .catch(response => dispatch({ type: 'ERR', payload: response}));
        getting(routes('api.searchpanels.index'))
            .then(response => {
                dispatch({ type: 'GET-SEARCHPANELS', payload: response.data })
                dispatch({ type: 'SUCCESS', message: 'پنل های جستجو دریافت شد' })
            })
            .catch( error => { console.log(error.response) } );
    }
}

export const setSearchPanel = (searchPanelId, path, data) => {
    return (dispatch) => {
        dispatch({ type: 'SET-SEARCHPANEL', searchPanelId, data, path })
    }
}

export const orderSearchPanel = (id, path, from, to) => {
    return (dispatch) => {
        dispatch({ type: 'ORDER-SEARCHPANEL', id, path, from, to })
    }
}

export const resetSearchPanel = (searchPanelId) => {
    return (dispatch) => {
        dispatch({ type: 'RESET-SEARCHPANEL', searchPanelId })
        dispatch({ type: 'SUCCESS', message: 'پنل جستجو به حالت اولیه بازگشت.' })
    }
}

export const copySearchPanel = (id, callback) => {
    callback();
    return (dispatch) => {
        dispatch({ type: 'COPY-SEARCHPANEL', id })
        dispatch({ type: 'SUCCESS', message: 'پنل در فرم ایجاد رونوشت شد.' })
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
            .catch( error => { console.log(error.response) } );
    }
} 

export const updateSearchPanel = (searchpanel) => {
    return (dispatch) => {
        putting(routes('api.searchpanels.update',[searchpanel.id]), searchpanel.attributes)
            .then(response => {
                dispatch({ type: 'UPDATE-SEARCHPANEL', searchpanel })
                dispatch({ type: 'SUCCESS', message: 'پنل با موفقیت ذخیره شد' })
            })
            .catch(response => dispatch({ type: 'ERR', payload: response}));
    }
}

export const deleteSearchPanel = (id, callback) => {
    return (dispatch) => {
        deleting(routes('api.searchpanels.delete', [id]))
            .then(response => {
                callback();
                dispatch({ type: 'DELETE-SEARCHPANEL', id, payload: response.data })
                dispatch({ type: 'SUCCESS', message: 'پنل با موفقیت به زباله دان انتقال یافت.' });
            })
            .catch(response => dispatch({ type: 'ERR', payload: response}));
    }
}

export const restoreSearchPanel = (deleted_id) => {
    return (dispatch) => {
        getting(routes('api.searchpanels.restore', [deleted_id]))
            .then(response => {
                dispatch({ type: 'RESTORE-SEARCHPANEL', deleted_id, payload: response.data });
                dispatch({ type: 'SUCCESS', message: 'پنل با موفقیت بازیابی شد.' });
            })
            .catch(response => dispatch({ type: 'ERR', payload: response}));
    }
}