const initialState = {
    redirect: null,
};
export const AppReducer = (state = initialState, action) => {
    switch (action.type) {
        case 'APP-REDIRECT':
            state.redirect = action.payload;
            return state;
        case 'APP-CLEAR-REDIRECT':
            state.redirect = null;
            return state;
        default:
            return state;
    }
};