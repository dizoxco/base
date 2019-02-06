const initialState = {
    index: [],
    mediagroups: []
}
export const MediaReducer = (state = initialState, action) => {
    switch (action.type) {
        case 'GET-MEDIAGROUP':
            let i = state.mediagroups.findIndex((e) => e.id == action.mediagroup );
            state.mediagroups[i].media = action.payload.data;
            return state;
        case 'GET-MEDIAGROUPS':
            return {
                ...state,
                mediagroups: action.payload.data
            };
        default:
            return state;
    }
}