import { reduxCopy, reduxDelete, reduxReset, reduxRestore, reduxSet, reduxStore, reduxUpdate } from "../../helpers";

export const UserReducer = (state = initialState, action) => {
    switch (action.type) {
        case 'COPY-USER': return reduxCopy(state, action)
        case 'DELETE-USER': return reduxDelete(state, action)
        case 'GET-USERS': return { ...state, index: action.payload.data }
        case 'GET-TRASH-USERS': return { ...state, trash: action.payload.data }
        case 'LOGOUT': return { ...state, token: null }
        case 'RESET-USER': return reduxReset(state, action)
        case 'RESTORE-USER': return reduxRestore(state, action)           
        case 'SET-USER': return reduxSet(state, action)
        case 'STORE-USER': return reduxStore(state, action)
        case 'TOKEN': return { ...state, token: action.payload.access_token }
        case 'UPDATE-USER': return reduxUpdate(state, action)
        default: return state
    }
}

const init = {
    type: 'user',
    attributes:{
        name: '',
        email: '',
        slug: '',
        created_at: null,
        updated_at: null,
        deleted_at: null,
    }
};
const initialState = {
    index: [],
    trash: [],
    init: {...init},
    create: {...init, id: 0},
};