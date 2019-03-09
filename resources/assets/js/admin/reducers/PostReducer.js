const init = {
    type: 'post',
    attributes: {
        title: '',
        slug: '',
        abstract: '',
        body: '',
        deleted_at: null
    },
    relations: {
        tags: []
    }
};
const initialState = {
    index: [],
    trash: [],
    init: {...init},
    create: {...init, id: 0},
};
export const PostReducer = (state = initialState, action) => {
    let i;
    if(action.id != undefined && action.id != 0 ){
        i = state.index.findIndex((e) => e.id == action.id );
    }
    function backup(){
        if (i != undefined) {
            if(state.index[i].oldAttributes == undefined) state.index[i].oldAttributes = {...state.index[i].attributes};
            if(state.index[i].oldRelations == undefined) state.index[i].oldRelations = {...state.index[i].relations};
        }else{
            if(state.create.oldAttributes == undefined) state.create.oldAttributes = {...state.create.attributes};
            if(state.create.oldRelations == undefined) state.create.oldRelations = {...state.create.relations};
        }
    }
    switch (action.type) {
        case 'COPY-POST':
            state.create.attributes = {...state.index[i].attributes}
            state.create.oldAttributes = {...state.init.attributes}
            state.create.relations = {...state.index[i].relations}
            state.create.oldRelations = {...state.init.relations}
            return state;
        case 'DELETE-POST':
            delete state.index.splice(i, 1);
            return state;
        case 'GET-POSTS':
            return {
                ...state,
                index: action.payload.data
            };
        case 'GET-TRASH-POSTS':
            return {
                ...state,
                trash: action.payload.data
            };
        case 'RESET-POST':
            if(action.id == 0){
                state.create = {...state.init, id: 0};
            }else{
                state.index[i].attributes = {...state.index[i].oldAttributes};
                state.index[i].relations = {...state.index[i].oldRelations};
                delete state.index[i].oldAttributes;
                delete state.index[i].oldRelations;
            }
            return state;
        case 'RESTORE-POST':
            i = state.trash.findIndex((e) => e.id == action.deleted_id );
            state.trash[i].attributes.deleted_at= null;
            state.index.push(state.trash[i]);
            delete state.trash.splice(i, 1);
            return state;
        case 'SET-POST':
            backup();
            if(action.id == 0){
                state.create.attributes = {...state.create.attributes, ...action.attributes}
            }else{
                state.index[i].attributes = { ...state.index[i].attributes, ...action.attributes };
            }
            return state;
        case 'SET-POST-TAGS':
            backup();
            var oldTags = (i==undefined)? state.create.relations.tags: state.index[i].relations.tags;
            var tags = action.tags;
            oldTags.forEach(tag => {
                let add = true;
                action.taxonomy_tags.forEach(tax_tag => {
                    if (tax_tag.id == tag) add = false
                })
                if (add) tags.push(tag);
            })
            if (i==undefined) {
                state.create.relations = {...state.create.relations, tags};
            }else{
                state.index[i].relations = {...state.index[i].relations, tags};
            }
            return state;
        case 'STORE-POST':
            state.index.push(action.payload.data);
            state.create = state.init;            
            return state;
        case 'UPDATE-POST':
            delete state.index[i].oldAttributes;
            delete state.index[i].oldRelations;
            return state;
        case 'RESTORE-POST':
            i = state.trash.findIndex((e) => e.id == action.deleted_id );
            state.trash[i].attributes.deleted_at= null;
            state.index.push(state.trash[i]);
            delete state.trash.splice(i, 1);
            return state;
        default:
            return state;
    }
}