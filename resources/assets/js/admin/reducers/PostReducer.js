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
        case 'SET-POST':
            let index = state.posts.findIndex((e) => e.id == action.id );
            if(state.posts[index].oldAttributes == undefined){
                state.posts[index].oldAttributes = state.posts[index].attributes;                
            }
            state.posts[index].attributes = { ...state.posts[index].attributes, ...action.attributes };
            return{
                ...state
            }
        default:
            return state;
    }
}