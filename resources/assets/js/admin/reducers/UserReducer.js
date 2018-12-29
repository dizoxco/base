const initialState = {
    token: null,
    info: null
}
const UserReducer = (state = initialState, action) => {
    switch (action.type) {
        case 'INCREMENT':
            return {
                ...state,
                counter: state.counter + 1
            };
            break;
        default:
            return state;
            break;
    }
}
export default UserReducer;