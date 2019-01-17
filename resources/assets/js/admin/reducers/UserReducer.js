const initialState = {
    token: null,
    user: null,
    users: []
}
export const UserReducer = (state = initialState, action) => {
    switch (action.type) {
        case 'GET-USERS':
            return {
                ...state,
                users: action.payload.data
            }
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