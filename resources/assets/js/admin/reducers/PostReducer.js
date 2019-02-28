const init = {
    type: 'post',
    attributes: {
        title: '',
        slug: '',
        abstract: '',
        body: ''
    }
};
const initialState = {
    index: [],
    init,
    create: {...init, id: 0},
}
export const PostReducer = (state = initialState, action) => {
    switch (action.type) {
        case 'GET-POSTS':
            return {
                ...state,
                index: action.payload.data
            }
        case 'STORE-POST':
            state.index.push(action.payload.data);
            state.create = state.init;            
            return state;
        case 'SET-POST':
            if(action.id == 0){
                state.create.attributes = {...state.create.attributes, ...action.attributes}
            }else{
                let i = state.index.findIndex((e) => e.id == action.id );
                if(state.index[i].oldAttributes == undefined){
                    state.index[i].oldAttributes = state.index[i].attributes;
                }
                state.index[i].attributes = { ...state.index[i].attributes, ...action.attributes };
            }
            return state;
        case 'UPDATE-POST':
            let updatedIndex = state.index.findIndex((e) => e.id == action.payload.data.id );
            state.index[updatedIndex].attributes = action.payload.data.attributes;
            delete state.index[updatedIndex].oldAttributes;
        default:
            return state;
    }
}