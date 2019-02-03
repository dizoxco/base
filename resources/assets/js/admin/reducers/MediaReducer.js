const initialState = {
    index: [],
    mediagroups: []
}
export const MediaReducer = (state = initialState, action) => {
    switch (action.type) {
        case 'GET-MEDIAGROUPS':
            return {
                ...state,
                mediagroups: action.payload.data
            }
        default:
            return state;
    }
}