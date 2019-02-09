const initialState = {
    index: [],
};
export const ProductReducer = (state = initialState, action) => {
    switch (action.type) {
        case 'GET-PRODUCTS':
            return {
                ...state,
                index: action.payload.data
            };
        case 'SET-PRODUCT':
            let i = state.index.findIndex((e) => e.id === action.id );
            if(state.index[i].oldAttributes === undefined){
                state.index[i].oldAttributes = state.index[i].attributes;
            }
            state.index[i].attributes = { ...state.index[i].attributes, ...action.attributes };
            return state;
        case 'UPDATE-PRODUCT':
            let updatedIndex = state.index.findIndex((e) => e.id === action.payload.data.id);
            state.index[updatedIndex].attributes = action.payload.data.attributes;
            delete state.index[updatedIndex].oldAttributes;
        default:
            return state;
    }
};