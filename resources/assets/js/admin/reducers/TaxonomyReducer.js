import { validator } from '../../helpers';
const init = {
    type: 'taxonomy',
    attributes: {
        parent_id: 0,
        taxonomy_id: 0,
        label: '',
        slug: '',
        metadata: '',
        deleted_at: null
    },
    relations: {
        tags: []
    } 
}; 
const initialState = {
    index: [],
    trash: [],
    // init,
    init: {...init},
    create: {...init, id: 0},
};
export const TaxonomyReducer = (state = initialState, action) => {
    let i;
    if(action.id != undefined && action.id != 0 ){
        i = state.index.findIndex((e) => e.id == action.id );
    }
    function backup(){
        if (i != undefined) {
            if(state.index[i].oldAttributes == undefined) state.index[i].oldAttributes = {...state.index[i].attributes};
            // if(state.index[i].oldRelations == undefined) state.index[i].oldRelations = {...state.index[i].relations};
        }else{
            if(state.create.oldAttributes == undefined) state.create.oldAttributes = {...state.create.attributes};
            // if(state.create.oldRelations == undefined) state.create.oldRelations = {...state.create.relations};
        }
    }
    switch (action.type) {
        case 'GET-TAXONOMIES':
            return {
                ...state,
                index: action.payload.data,
            };
        case 'GET-TRASH-TAXONOMIES':
        return {
            ...state,
            trash: action.payload.data
        }
        case 'VALIDATE-TAXONOMIES':
            // The object is being created or updated
            let i = state.index.findIndex((e) => e.id == action.id );

            let rules = {
                group_name: ['required'],
                slug: ['string'],
                label: ['numeric']
            };

            // merge current validation object with new object variation
            state.index[i].validation = validator(state.index[i], rules, action.field);

            return state;
        case 'STORE-TAXONOMY':
            state.index.push(action.payload.data);
            state.create = state.init;
            return state;
        case 'SET-TAXONOMIES':
            if(action.id == 0){
                state.create.attributes = {...state.create.attributes, ...action.attributes}
            }else{
                let i = state.index.findIndex((e) => e.id == action.id );
                if(state.index[i].oldAttributes == undefined){
                    state.index[i].oldAttributes = state.index[i].attributes;
                }
                state.index[i].attributes = { ...state.index[i].attributes, ...action.attributes };
            }
            return state;
        case 'RESET-TAXONOMY':        
            if(action.id == 0){
                state.create = {...state.init, id: 0};
            }else{
                
                state.index[i].attributes = {...state.index[i].oldAttributes};
                // state.index[i].relations = {...state.index[i].oldRelations};
                delete state.index[i].oldAttributes;
                // delete state.index[i].oldRelations;
            }
            return state;
        case 'COPY-TAXONOMY':
            state.create.attributes = {...state.index[i].attributes}
            state.create.oldAttributes = {...state.init.attributes}
            // state.create.relations = {...state.index[i].relations}
            // state.create.oldRelations = {...state.init.relations}
            return state;
        case 'UPDATE-TAXONOMY':
            let updatedIndex = state.index.findIndex((e) => e.id == action.payload.data.id );
            state.index[updatedIndex].attributes = action.payload.data.attributes;
            delete state.index[updatedIndex].oldAttributes;
            return state;
        case 'DELETE-TAXONOMY':
            delete state.index.splice(i, 1);
            return state;
        case 'RESTORE-TAXONOMY':
            i = state.trash.findIndex((e) => e.id == action.deleted_id );
            state.trash[i].attributes.deleted_at= null;
            state.index.push(state.trash[i]);
            delete state.trash.splice(i, 1);
            return state;
        default:
            return state;
    }
};