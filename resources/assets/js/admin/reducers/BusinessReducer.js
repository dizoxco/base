const initialState = {
    index: [],
}
export const BusinessReducer = (state = initialState, action) => {
    switch (action.type) {
        case 'GET-BUSINESSES':
            return {
                ...state,
                index: action.payload.data
            }
        default:
            return state;
    }
}