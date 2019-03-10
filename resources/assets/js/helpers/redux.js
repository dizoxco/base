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

export const reduxSet = (obj, action) => {
    reduxBackup(obj);
    var pList = action.path.split('[').join('.').split('].').join('.').split('.');
    var len = pList.length;
    for(var ii = 0; ii < len-1; ii++) {
        var elem = pList[ii];
        if( !obj[elem] ) obj[elem] = {}
        obj = obj[elem];
    }
    obj[pList[len-1]] = action.data;
}

export const reduxReset = (obj) => {
    if (obj.oldAttributes != undefined) {
        obj.attributes = {...obj.oldAttributes}
        delete obj.oldAttributes;
    }
    if (obj.oldRelations != undefined) {
        obj.relations = {...obj.oldRelations};
        delete obj.oldRelations;
    }
}

export const reduxCopy = (obj) => {
    state.create.attributes = {...obj.attributes}
    state.create.oldAttributes = {...state.init.attributes}
    // state.create.relations = {...state.index[i].relations}
    // state.create.oldRelations = {...state.init.relations}
}

export const reduxOrder = (obj) => {
    // state.create.attributes = {...obj.attributes}
    // state.create.oldAttributes = {...state.init.attributes}
    // state.create.relations = {...state.index[i].relations}
    // state.create.oldRelations = {...state.init.relations}
}