const initialState = {
    businesses: [],
}
export const BusinessReducer = (state = initialState, action) => {
    switch (action.type) {
        case 'GET-BUSINESSES':
            return {
                ...state,
                businesses: action.payload.data
            }
        default:
            return state;
    }
}