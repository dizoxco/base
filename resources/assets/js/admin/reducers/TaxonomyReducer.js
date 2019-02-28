const initialState = {
    index: [],
    tags: []
};
export const TaxonomyReducer = (state = initialState, action) => {
    switch (action.type) {
        case 'GET-TAXONOMIES':
            return {
                index: action.payload.data,
                tags: action.payload.included.tags,
            };
        default:
            return state;
    }
};