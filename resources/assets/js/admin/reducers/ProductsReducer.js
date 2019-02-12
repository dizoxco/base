const initialState = {
    index: [{id:0,attributes:{}}],
    init:{id:0,attributes:{}}
};
export const ProductReducer = (state = initialState, action) => {
    switch (action.type) {
        case 'GET-PRODUCTS':
            return {
                ...state,
                index: state.index.concat(action.payload.data)
            };
        case 'SET-PRODUCT':
            let i = state.index.findIndex((e) => e.id === action.id );
            if(state.index[i].oldAttributes === undefined){
                state.index[i].oldAttributes = state.index[i].attributes;
            }
            state.index[i].attributes = { ...state.index[i].attributes, ...action.attributes };
            return state;
        case 'STORE-PRODUCT':
            state.index.push(action.payload.data);
            state.index[0].attributes = state.index[0].oldAttributes;
            delete state.index[0].oldAttributes;
            return state;
        case 'UPDATE-PRODUCT':
            let updatedIndex = state.index.findIndex((e) => e.id === action.payload.data.id);
            state.index[updatedIndex].attributes = action.payload.data.attributes;
            delete state.index[updatedIndex].oldAttributes;
        default:
            return state;
    }
};