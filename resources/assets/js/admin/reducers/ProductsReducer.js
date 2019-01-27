const initialState = {
    products: [],
}
export const ProductReducer = (state = initialState, action) => {
    switch (action.type) {
        case 'GET-PRODUCTS':
            return {
                ...state,
                products: action.payload.data
            }
        default:
            return state;
    }
}