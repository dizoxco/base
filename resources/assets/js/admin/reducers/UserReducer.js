const initialState = {
    token: null,
    info: null
}
export const UserReducer = (state = initialState, action) => {
    switch (action.type) {
        case 'TOKEN':
            return {
                ...state,
                token: action.payload.access_token
            };
        case 'LOGOUT': return {
                ...state,
                token: null
            };
        default:
            return state;
    }
}