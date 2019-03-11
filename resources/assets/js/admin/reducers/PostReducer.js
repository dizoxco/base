import { reduxCopy, reduxDelete, reduxReset, reduxRestore, reduxSet, reduxStore, reduxUpdate } from "../../helpers";

export const PostReducer = (state = initialState, action) => {
    switch (action.type) {
        case 'GET-POSTS': return { ...state, index: action.payload.data }
        case 'GET-TRASH-POSTS': return { ...state, trash: action.payload.data }
        case 'SET-POST': return reduxSet(state, action)
        case 'RESET-POST': return reduxReset(state, action)
        case 'COPY-POST': return reduxCopy(state, action)
        case 'STORE-POST': return reduxStore(state, action)
        case 'UPDATE-POST': return reduxUpdate(state, action)
        case 'DELETE-POST': return reduxDelete(state, action)
        case 'RESTORE-POST': return reduxRestore(state, action)
        default: return state
    }
}

const init = {
    type: 'post',
    attributes: {
        title: '',
        slug: '',
        abstract: '',
        body: '',
        deleted_at: null
    },
    relations: {
        tags: []
    }
};
const initialState = {
    index: [],
    trash: [],
    init: {...init},
    create: {...init, id: 0},
};