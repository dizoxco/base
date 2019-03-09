const init = {
    type: 'searchpanel',
    attributes: {
        title: '',
        slug: '', 
        description: '',
        options: {
            order: {
                order:[]
            }
        },
    } 
};
const initialState = {
    index: [],
    trash: [],
    init: {...init},
    create: {...init, id:0},
} 
export const SearchPanelReducer = (state = initialState, action) => {
    let i;
    if(action.id != undefined && action.id != 0 ){
        i = state.index.findIndex((e) => e.id == action.id );
    }

    switch (action.type) {
        case 'GET-SEARCHPANELS':
            return {
                ...state,
                index: action.payload.data
            }
        case 'GET-TRASH-SEARCHPANELS':
            return {
                ...state,
                trash: action.payload.data
            }
        case 'SET-SEARCHPANEL':
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
        case 'RESET-SEARCHPANEL':
            if(action.id == 0){
                state.create = {...state.init, id: 0};
            }else{
                state.index[i].attributes = {...state.index[i].oldAttributes};
                state.index[i].relations = {...state.index[i].oldRelations};
                delete state.index[i].oldAttributes;
                delete state.index[i].oldRelations;
            }
            return state;
        case 'COPY-SEARCHPANEL':
            state.create.attributes = {...state.index[i].attributes}
            state.create.oldAttributes = {...state.init.attributes}
            state.create.relations = {...state.index[i].relations}
            state.create.oldRelations = {...state.init.relations}
            return state;
        case 'STORE-SEARCHPANEL':
            state.index.push(action.payload.data);
            state.create = state.init;            
            return state;
        case 'UPDATE-SEARCHPANEL':
            let updatedIndex = state.index.findIndex((e) => e.id == action.searchpanel.id );
            delete state.index[updatedIndex].oldAttributes;
            return state;
        case 'DELETE-SEARCHPANEL':
            state.trash.push(state.index[i]);
            delete state.index.splice(i, 1);
            return state;
        case 'RESTORE-SEARCHPANEL':
            i = state.trash.findIndex((e) => e.id == action.deleted_id );
            state.trash[i].attributes.deleted_at= null;
            state.index.push(state.trash[i]);
            delete state.trash.splice(i, 1);
            return state;
        default:
            return state;
    }
} 