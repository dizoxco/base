const init = {
    type: 'tag',
    attributes: {
        parent_id: 0,
        taxonomy_id: 0,
        label: '',
        slug: '',
        metadata: ''
    }
};
const initialState = {
    index: [],
    init,
    create: {...init, id: 0},
};

export const TagReducer = (state = initialState, action) => {
    switch (action.type) {
        case 'GET-TAGS':
            return {
                ...state,
                index: action.payload.data
            };
        case 'UPDATE-TAG':
            let updatedIndex = state.index.findIndex((e) => e.id == action.payload.data.id );
            state.index[updatedIndex].attributes = action.payload.data.attributes;
            delete state.index[updatedIndex].oldAttributes;
            return state;
        case 'SET-TAG':
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
        case 'STORE-TAG':
            state.index.push(action.payload.data);
            state.create = state.init;
            return state;
        default:
            return state;
    }
};