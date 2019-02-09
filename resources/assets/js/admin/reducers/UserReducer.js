const initialState = {
    token: null,
    user: null,
    index: []
};
export const UserReducer = (state = initialState, action) => {
    switch (action.type) {
        case 'GET-USERS':
            return {
                ...state,
                index: action.payload.data
            };
        case 'SET-USER':
            let i = state.index.findIndex((e) => e.id === action.id);
            if (state.index[i].oldAttributes === undefined) {
                state.index[i].oldAttributes = state.index[i].attributes;
            }
            state.index[i].attributes = {...state.index[i].attributes, ...action.attributes};
            console.log(state.index[i]);
            return state;
        case 'TOKEN':
            return {
                ...state,
                token: action.payload.access_token
            };
        case 'LOGOUT':
            return {
                ...state,
                token: null
            };
        case 'UPDATE-USER':
            let updatedIndex = state.index.findIndex((e) => e.id === action.payload.data.id);
            state.index[updatedIndex].attributes = action.payload.data.attributes;
            delete state.index[updatedIndex].oldAttributes;
        default:
            return state;
    }
}