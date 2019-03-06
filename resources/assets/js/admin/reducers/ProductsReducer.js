const init = {
    type: 'product',
    attributes: {
        title: '',
        slug: '',
        abstract: '',
        body: ''
    },
    relations: {
        tags: []
    }
};

const initialState = {
    index: [],
    init,
    create: {...init, id: 0},
};

export const ProductReducer = (state = initialState, action) => {
    let i;
    switch (action.type) {
        case 'GET-PRODUCTS':
            return {
                ...state,
                index: state.index.concat(action.payload.data)
            };
        case 'SET-PRODUCT':
            i = state.index.findIndex((e) => e.id === action.id );
            if(state.index[i].oldAttributes === undefined){
                state.index[i].oldAttributes = state.index[i].attributes;
            }
            state.index[i].attributes = { ...state.index[i].attributes, ...action.attributes };
            return state;
        case 'SET-PRODUCT-TAGS':
            i = state.index.findIndex((e) => e.id == action.id );
            if(state.index[i].oldRelations == undefined){
                state.index[i].oldRelations = state.index[i].relations;
            }
            var tags = action.tags;
            state.index[i].relations.tags.forEach(tag => {
                let add = true;
                action.taxonomy_tags.forEach(tax_tag => {
                    if (tax_tag.id == tag) add = false
                })
                if (add) tags.push(tag);
            })

            state.index[i].relations.tags = tags;
            return state;
        case 'STORE-PRODUCT':
            state.index.push(action.payload.data);
            state.index[0].attributes = state.index[0].oldAttributes;
            delete state.index[0].oldAttributes;
            return state;
        case 'UPDATE-PRODUCT':
            let updatedIndex = state.index.findIndex((e) => e.id === action.payload.data.id);
            state.index[updatedIndex].attributes = action.payload.data.attributes;
            delete state.index[updatedIndex].oldAttributes;
        default:
            return state;
    }
};