const initialState = {
    index: [],
}
export const CommentReducer = (state = initialState, action) => {
    switch (action.type) {
        case 'GET-COMMENTS':
            return {
                ...state,
                index: action.payload.data
            }
        default:
            return state;
    }
}