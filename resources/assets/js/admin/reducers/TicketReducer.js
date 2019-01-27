const initialState = {
    tickets: [],
}
export const TicketReducer = (state = initialState, action) => {
    switch (action.type) {
        case 'GET-TICKETS':
            return {
                ...state,
                tickets: action.payload.data
            }
        default:
            return state;
    }
}