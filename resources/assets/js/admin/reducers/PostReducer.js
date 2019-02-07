const initialState = {
    index: [],
    post: null,
    counter: 7  
}
export const PostReducer = (state = initialState, action) => {
    switch (action.type) {
        case 'GET-POSTS':
            return {
                ...state,
                index: action.payload.data
            }
        case 'INCREMENT':
            return {
                ...state,
                counter: state.counter + 1
            };
        case 'SET-POST':
            let i = state.index.findIndex((e) => e.id == action.id );
            if(state.index[i].oldAttributes == undefined){
                state.index[i].oldAttributes = state.index[i].attributes;
            }
            state.index[i].attributes = { ...state.index[i].attributes, ...action.attributes };
            return state;
        case 'UPDATE-POST':
            let updatedIndex = state.index.findIndex((e) => e.id == action.payload.data.id );
            state.index[updatedIndex].attributes = action.payload.data.attributes;
            delete state.index[updatedIndex].oldAttributes;
        default:
            return state;
    }
}