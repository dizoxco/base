import { reduxBackup, reduxBind, reduxCopy, reduxReset, reduxSet } from "../../helpers";

export const SearchPanelReducer = (state = initialState, action) => {
    var searchpanel = reduxBind(state, action.searchPanelId);
    
    let i;
    if(action.id != undefined && action.id != 0 ){
        i = state.index.findIndex((e) => e.id == action.id );
    }

    switch (action.type) {
        case 'GET-SEARCHPANELS': return { ...state, index: action.payload.data }
        case 'GET-TRASH-SEARCHPANELS': return { ...state, trash: action.payload.data }
        case 'SET-SEARCHPANEL': reduxSet(searchpanel, action); return state
        case 'ORDER-SEARCHPANEL': reduxBackup(state.index[i]); return state
        case 'RESET-SEARCHPANEL': reduxReset(searchpanel); return state
        case 'COPY-SEARCHPANEL': reduxCopy(state, searchpanel); return state
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