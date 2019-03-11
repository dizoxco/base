import { reduxCopy, reduxDelete, reduxReset, reduxRestore, reduxSet, reduxStore, reduxUpdate } from "../../helpers";

export const TaxonomyReducer = (state = initialState, action) => {
    switch (action.type) {
        case 'GET-TAXONOMIES': return { ...state, index: action.payload.data }
        case 'GET-TRASH-TAXONOMIES': return { ...state, trash: action.payload.data }
        case 'VALIDATE-TAXONOMIES':
            // The object is being created or updated
            let i = state.index.findIndex((e) => e.id == action.id );

            let rules = {
                group_name: ['required'],
                slug: ['string'],
                label: ['numeric']
            };

            // merge current validation object with new object variation
            state.index[i].validation = validator(state.index[i], rules, action.field);

            return state;
        case 'STORE-TAXONOMY': return reduxStore(state, action)
        case 'SET-TAXONOMY': return reduxSet(state, action)
        case 'RESET-TAXONOMY': return reduxReset(state, action)
        case 'COPY-TAXONOMY': return reduxCopy(state, action)
        case 'UPDATE-TAXONOMY': return reduxUpdate(state, action)
        case 'DELETE-TAXONOMY': return reduxDelete(state, action)
        case 'RESTORE-TAXONOMY': return reduxRestore(state, action)
        default: return state
    }
};

const init = {
    type: 'taxonomy',
    attributes: {
        parent_id: 0,
        taxonomy_id: 0,
        label: '',
        slug: '',
        metadata: '',
        deleted_at: null
    },
    relations: {
        tags: []
    } 
};
const initialState = {
    index: [],
    trash: [],
    // init,
    init: {...init},
    create: {...init, id: 0},
};