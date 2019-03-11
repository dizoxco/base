import { reduxCopy, reduxDelete, reduxReset, reduxRestore, reduxSet, reduxStore, reduxUpdate } from "../../helpers";

export const TagReducer = (state = initialState, action) => {
    switch (action.type) {
        case 'GET-TAGS': return { ...state, index: action.payload.data }
        case 'STORE-TAG': return reduxStore(state, action)
        case 'SET-TAG': return reduxSet(state, action)
        case 'RESET-TAG': return reduxReset(state, action)
        case 'COPY-TAG': return reduxCopy(state, action)
        case 'UPDATE-TAG': return reduxUpdate(state, action)
        case 'DELETE-TAG': return reduxDelete(state, action)
        case 'RESTORE-TAG': return reduxRestore(state, action)
        default: return state;
    }
};

const init = {
    type: 'tag',
    attributes: {
        parent_id: 0,
        taxonomy_id: 0,
        label: '',
        slug: '',
        metadata: '',
        deleted_at: null
    }
};
const initialState = {
    index: [],
    trash: [],
    init: {...init},
    create: {...init, id: 0},
};