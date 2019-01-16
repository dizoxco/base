const initialState = {
    token: null,
    user: null,
    users: null
}
export const UserReducer = (state = initialState, action) => {
    switch (action.type) {
        case 'GET-USERS':
            break;
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