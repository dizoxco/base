const initialState = {index: []};
export const CityReducer = (state = initialState, action) => {
    switch (action.type) {
        case 'GET-CITIES':
            return {
                ...state,
                index: action.payload.data
            };
        default:
            return state;
    }
};