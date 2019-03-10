import routes from '../routes';
import {deleting, getting, posting, putting, setCookie} from "../../helpers";

export const getTaxonomies = () => {
    return (dispatch) => {
        getting(routes('api.taxonomies.trash'))
            .then(response => dispatch({type: 'GET-TRASH-TAXONOMIES', payload: response.data}))
            .catch(response => dispatch({ type: 'ERR', payload: response}));
        getting(routes('api.taxonomies.index'))
            .then(response => {
                dispatch({ type: 'GET-TAXONOMIES', payload: response.data })
                dispatch({ type: 'SUCCESS', message: 'تگ ها دریافت شد' })
            })
            // .then(response =>{dispatch({
            //     type: 'GET-TAXONOMIES',
            //     payload: response.data
            // })})
            .catch(response => dispatch({ type: 'ERR', payload: response}));
    }
};
 
export const validateTaxonomy = (id, field = null) => {
    return (dispatch) => {
        dispatch({ type: 'VALIDATE-TAXONOMIES', id, field })
    };
};  

export const storeTaxonomy = (taxonomy, callback) => {
    return (dispatch) => {
        posting(routes('api.taxonomies.store'), taxonomy.attributes)
            .then((response) => {
                callback();
                dispatch({ type: 'STORE-TAXONOMY', payload: response.data });
                dispatch({ type: 'SUCCESS', message: 'تگ با موفقیت ذخیره شد' });
                // return dispatch({
                //     type: 'STORE-TAXONOMIES',
                //     payload: response.data
                // })
            })
            .catch(response => dispatch({ type: 'ERR', payload: response}));
    };
};

export const setTaxonomy = (id, attributes) => {
    return (dispatch) => {
        dispatch({ type: 'SET-TAXONOMIES', id, attributes })
    };
};

export const resetTaxonomy = (id) => {
    return (dispatch) => {
        dispatch({ type: 'RESET-TAXONOMY ', id })
        dispatch({ type: 'SUCCESS', message: 'تگ به حالت اولیه بازگشت.' })
    }
}

export const copyTaxonomy = (id, callback) => {
    callback();
    return (dispatch) => {
        dispatch({ type: 'COPY-TAXONOMY', id })
        dispatch({ type: 'SUCCESS', message: 'تگ در فرم ایجاد رونوشت شد.' })
    }
}

export const updateTaxonomy = (taxonomy, callback) => {
    return (dispatch) => {
        putting(routes('api.taxonomies.update',[taxonomy.id]), taxonomy.attributes)
        .then(response => {
            dispatch({ type: 'UPDATE-TAXONOMY', id: taxonomy.id, payload: response.data });
            dispatch({ type: 'SUCCESS', message: 'تگ با موفقیت ذخیره شد' });
        })
        // .then((response) => {
            //     callback();
            //     return dispatch({
            //         type: 'UPDATE-TAXONOMIES',
            //         payload: response.data
            //     })
            // })
            .catch(response => dispatch({ type: 'ERR', payload: response}));
    };
};

export const deleteTaxonomy = (id, callback) => {
    return (dispatch) => {
        deleting(routes('api.taxonomies.delete', [id]))
            .then(response => {
                callback();
                dispatch({ type: 'DELETE-TAXONOMY', id, payload: response.data })
                dispatch({ type: 'SUCCESS', message: 'تگ با موفقیت به زباله دان انتقال یافت.' });
            })
            .catch(response => dispatch({ type: 'ERR', payload: response}));
    }
}

export const restoreTaxonomy = (deleted_id) => {
    return (dispatch) => {
        getting(routes('api.taxonomies.restore', [deleted_id]))
            .then(response => {
                dispatch({ type: 'RESTORE-TAXONOMY', deleted_id, payload: response.data });
                dispatch({ type: 'SUCCESS', message: 'تگ با موفقیت بازیابی شد.' });
            })
            .catch(response => dispatch({ type: 'ERR', payload: response}));
    }
}