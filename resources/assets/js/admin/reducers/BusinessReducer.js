const initialState = {
    index: [{id:0,attributes:{}}],
    init:{id:0,attributes:{}}
};
export const BusinessReducer = (state = initialState, action) => {
    switch (action.type) {
        case 'GET-BUSINESSES':
            return {
                ...state,
                index: action.payload.data
            };
        case 'SET-BUSINESS':
            let i = state.index.findIndex((e) => e.id === action.id );
            if(state.index[i].oldAttributes === undefined){
                state.index[i].oldAttributes = state.index[i].attributes;
            }
            state.index[i].attributes = { ...state.index[i].attributes, ...action.attributes };
            return state;
        case 'STORE-BUSINESS':
            state.index.push(action.payload.data); //real code
            state.index[0].attributes = state.index[0].oldAttributes;
            delete state.index[0].oldAttributes;
            return state;
        case 'UPDATE-BUSINESS':
            let updatedIndex = state.index.findIndex((e) => e.id === action.payload.data.id );
            state.index[updatedIndex].attributes = action.payload.data.attributes;
            delete state.index[updatedIndex].oldAttributes;
        default:
            return state;
    }
};