const initialState = {
    index: [],
};
export const TaxonomyReducer = (state = initialState, action) => {
    switch (action.type) {
        case 'GET-TAXONOMIES':
            return {
                ...state,
                index: action.payload.data
            };
        default:
            return state;
    }
};