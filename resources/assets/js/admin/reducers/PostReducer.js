const initialState = {
    posts: [],
    post: null,
    counter: 7  
}
const PostReducer = (state = initialState, action) => {
    switch (action.type) {
        case 'INCREMENT':
            return {
                ...state,
                counter: state.counter + 1
            };
            break;
        default:
            return state;
            break;
    }
}
export default PostReducer;