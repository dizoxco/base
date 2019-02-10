const initialState = {
    token: null,
    user: null,
    index: [],
    init:{id:0,attributes:{}}
};
export const UserReducer = (state = initialState, action) => {
    switch (action.type) {
        case 'GET-USERS':
            return {
                ...state,
                index: action.payload.data
            };
        case 'SET-USER':
            if (action.id == 0){
                state.init.attributes = {...state.init.attributes, ...action.attributes}
            } else {
                let i = state.index.findIndex((e) => e.id === action.id);
                if (state.index[i].oldAttributes === undefined) {
                    state.index[i].oldAttributes = state.index[i].attributes;
                }
                state.index[i].attributes = {...state.index[i].attributes, ...action.attributes};
            }
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
        case 'STORE-USER':
            state.index.unshift(action.payload.data);
            state.init = {id:0,attributes:{}};
            return state;
        case 'UPDATE-USER':
            let updatedIndex = state.index.findIndex((e) => e.id === action.payload.data.id);
            state.index[updatedIndex].attributes = action.payload.data.attributes;
            delete state.index[updatedIndex].oldAttributes;
        default:
            return state;
    }
}