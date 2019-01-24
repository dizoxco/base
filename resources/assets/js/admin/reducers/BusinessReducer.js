const initialState = {
    businesses: [],
}
export const BusinessReducer = (state = initialState, action) => {
    switch (action.type) {
        case 'GET-BUSINESSES':
            console.log('sdfsdfsdf');
            
            console.log(action.payload);
            
            return {
                ...state,
                businesses: action.payload.data
            }
        // case 'SET-BUSINESS':
            // let index = state.posts.findIndex((e) => e.id == action.id );
            // if(state.posts[index].oldAttributes == undefined){
            //     state.posts[index].oldAttributes = state.posts[index].attributes;                
            // }
            // state.posts[index].attributes = { ...state.posts[index].attributes, ...action.attributes };
            // return{
            //     ...state
            // }
        default:
            return state;
    }
}