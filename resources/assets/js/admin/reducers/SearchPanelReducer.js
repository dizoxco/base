// const initialState = {
//     index: [],
//     // init:{id:0,attributes:{}}
// }
const init = {
    type: 'searchpanel',
    attributes: {
        title: '',
        slug: '',
        description: ''
    }
};
const initialState = {
    index: [],
    init,
    create: {...init, id:0},
} 
export const SearchPanelReducer = (state = initialState, action) => {
    switch (action.type) {
        case 'GET-SEARCHPANELS':
            return {
                ...state,
                index: action.payload.data
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

        case 'STORE-SEARCHPANEL':
            state.index.push(action.payload.data);
            state.create = state.init;            
            return state;
        case 'UPDATE-SEARCHPANEL':
            let updatedIndex = state.index.findIndex((e) => e.id == action.searchpanel.id );
            // state.index[updatedIndex].attributes = action.payload.data.attributes;
            delete state.index[updatedIndex].oldAttributes;
        default:
            return state;
    }
} 