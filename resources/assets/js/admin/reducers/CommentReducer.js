const initialState = {
    comments: [],
}
export const CommentReducer = (state = initialState, action) => {
    switch (action.type) {
        case 'GET-COMMENTS':
            return {
                ...state,
                comments: action.payload.data
            }
        default:
            return state;
    }
}