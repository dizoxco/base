const initialState = {
    index: [],
}
export const ProductReducer = (state = initialState, action) => {
    switch (action.type) {
        case 'GET-PRODUCTS':
            return {
                ...state,
                index: action.payload.data
            }
        default:
            return state;
    }
}