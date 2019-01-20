const initialState = {
    posts: [],
    post: null,
    counter: 7  
}
export const PostReducer = (state = initialState, action) => {
    switch (action.type) {
        case 'GET-POSTS':
            return {
                ...state,
                posts: action.payload.data
            }
        case 'INCREMENT':
            return {
                ...state,
                counter: state.counter + 1
            };
        default:
            return state;
    }
}