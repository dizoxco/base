import {deleting, getting, posting, putting} from "./";
import routes from '../admin/routes';

export const reduxBind = (state, id) => {
    if(id == undefined){
        return undefined;
    }
    if (id == 0){
        return state.create
    }else{
        return state.index[ state.index.findIndex((e) => e.id == id ) ];
    }
}

export const reduxBackup = (obj) => {
    if(obj.oldAttributes == undefined){
        obj.oldAttributes = {...obj.attributes};
    }
}

export const reduxSet = (state, action) => {    
    var obj = reduxBind(state, action.obj.id);
    reduxBackup(obj);
    var pList = action.path.split('[').join('.').split('].').join('.').split('.');
    var len = pList.length;
    for(var ii = 0; ii < len-1; ii++) {
        var elem = pList[ii];
        if( !obj[elem] ) obj[elem] = {}
        obj = obj[elem];
    }
    obj[pList[len-1]] = action.data;
    return state;
}

export const reduxReset = (state, action) => {
    var obj = reduxBind(state, action.obj.id);
    if (obj.oldAttributes != undefined) {
        obj.attributes = {...obj.oldAttributes}
        delete obj.oldAttributes;
    }
    if (obj.oldRelations != undefined) {
        obj.relations = {...obj.oldRelations};
        delete obj.oldRelations;
    }
    return state
}

export const reduxCopy = (state, action) => {
    var obj = reduxBind(state, action.obj.id);
    state.create.attributes = {...obj.attributes}
    state.create.oldAttributes = {...state.init.attributes}
    // state.create.relations = {...state.index[i].relations}
    // state.create.oldRelations = {...state.init.relations}
    return state
}

export const reduxOrder = (obj) => {
    // state.create.attributes = {...obj.attributes}
    // state.create.oldAttributes = {...state.init.attributes}
    // state.create.relations = {...state.index[i].relations}
    // state.create.oldRelations = {...state.init.relations}
}

export const reduxStore = (state, action) => {
    state.index.push(action.payload.data);
    state.create = {...state.init};
    return state;
}

export const reduxUpdate = (state, action) => {
    var obj = reduxBind(state, action.obj.id)
    if (obj.oldAttributes != undefined) {
        delete obj.oldAttributes
    }
    if (obj.oldRelations != undefined) {
        delete obj.oldRelations
    }
    return state
}

export const reduxDelete = (state, action) => {
    var obj = reduxBind(state, action.obj.id)
    state.trash.push(obj);
    delete state.index.splice(state.index.findIndex((e) => e.id == action.obj.id ), 1);
    return state;
}

export const reduxRestore = (state, action) => {
    i = state.trash.findIndex((e) => e.id == action.obj.id );
    state.trash[i].attributes.deleted_at= null;
    state.index.push(state.trash[i]);
    state.trash.splice(i, 1);
    return state;
}







export const reduxGetter = (reducer, trash=true) => {
    return (dispatch) => {
        if (trash && routes('api.'+reducers[reducer].pluralName+'.trash') != undefined) {
            getting(routes('api.'+reducers[reducer].pluralName+'.trash'))
                .then(response => dispatch({
                    type: 'GET-TRASH-' + reducers[reducer].pluralName.toUpperCase(), 
                    payload: response.data
                }))
                .catch(response => dispatch({ type: 'ERR', payload: response}));
        }

        getting(routes('api.'+reducers[reducer].pluralName+'.index'))
            .then(response => {
                dispatch({ 
                    type: 'GET-' + reducers[reducer].pluralName.toUpperCase(),
                    payload: response.data
                });
                dispatch({
                    type: 'SUCCESS',
                    message: 'اطلاعات ' + reducers[reducer].pluralLabel + ' بارگیری شد.' })
            })
            .catch(response => dispatch({ type: 'ERR', payload: response}));
    }
}

export const reduxSeter = (obj, path, data) => {
    // console.log(obj);
    
    return (dispatch) => { dispatch({ 
        type: 'SET-' + obj.type.toUpperCase(),
        obj,
        path,
        data 
    })}
}

export const reduxReseter = (obj) => {
    return (dispatch) => { dispatch({ 
        type: 'RESET-' + obj.type.toUpperCase(),
        obj 
    })}
}

export const reduxCopier = (obj, callback) => {
    callback();
    return (dispatch) => {
        dispatch({ 
            type: 'COPY-' + obj.type.toUpperCase(),
            obj 
        })
        dispatch({ type: 'SUCCESS', message: reducers[obj.type].label + ' در فرم ایجاد رونوشت شد.' })
    }
}

export const reduxStorer = (obj) => {
    return (dispatch) => {
        if(obj.id == 0){
            posting(
                    routes('api.' + reducers[obj.type].pluralName + '.store'), 
                    {...obj.attributes, ...obj.relations}
                )
                .then(response => {
                    dispatch({ 
                        type: 'STORE-' + obj.type.toUpperCase(),
                        obj,
                        payload: response.data
                    });
                    dispatch({
                        type: 'SUCCESS',
                        message: reducers[obj.type].label + ' با موفقیت ذخیره شد'
                    });
                })
                .catch(response => dispatch({ type: 'ERR', payload: response}));
        }else{
            putting(routes('api.' + reducers[obj.type].pluralName + '.update', [obj.id]), {...obj.attributes, ...obj.relations})
            .then(response => {
                dispatch({
                    type: 'UPDATE-' + obj.type.toUpperCase(),
                    obj,
                    payload: response.data
                });
                dispatch({
                    type: 'SUCCESS',
                    message: reducers[obj.type].label + ' با موفقیت ذخیره شد'
                });
            })
            .catch(response => dispatch({ type: 'ERR', payload: response}));
        }
    }
};

export const reduxDeleter = (obj, callback) => {
    return (dispatch) => {
        deleting(routes('api.' + reducers[obj.type].pluralName + '.delete', [obj.id]))
            .then(response => {
                callback();
                dispatch({
                    type: 'DELETE-' + obj.type.toUpperCase(),
                    obj,
                    payload: response.data
                });
                dispatch({ 
                    type: 'SUCCESS',
                    message: reducers[obj.type].label + ' با موفقیت به زباله دان انتقال یافت.'
                });
            })
            .catch(response => dispatch({ type: 'ERR', payload: response}));
    }
};

export const reduxRestorer = (obj) => {
    return (dispatch) => {
        getting(routes('api.' + reducers[obj.type].pluralName + '.restore', [obj.id]))
            .then(response => {
                dispatch({
                    type: 'RESTORE-' + obj.type.toUpperCase(),
                    payload: response.data
                });
                dispatch({
                    type: 'SUCCESS',
                    message: reducers[obj.type].label + ' با موفقیت بازیابی شد.'
                });
            })
            .catch(response => dispatch({ type: 'ERR', payload: response}));
    }
};






const reducers = {
    post: {
        pluralName: 'posts',
        label: 'مطلب',
        pluralLabel: 'مطالب',
    },
    tag: {
        pluralName: 'tags',
        label: 'تگ',
        pluralLabel: 'تگ ها',
    },
    taxonomy: {
        pluralName: 'taxonomies',
        label: 'گروه تگ',
        pluralLabel: 'گروه های تگ',
    },
    user: {
        pluralName: 'users',
        label: 'کاربر',
        pluralLabel: 'کاربران',
    }
}