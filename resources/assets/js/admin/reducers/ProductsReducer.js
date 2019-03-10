const init = {
    type: 'product',
    attributes: {
        title: '',
        slug: '',
        abstract: '',
        body: ''
    },
    relations: {
        tags: [],
        users: [],
        comments: [],
    }
};
const initialState = {
    index: [],
    trash: [],
    init: {...init},
    create: {...init, id: 0},
};
export const ProductReducer = (state = initialState, action) => {
    let i;
    if(action.id != undefined && action.id != 0 ){
        i = state.index.findIndex((e) => e.id == action.id );
    }

    const backup = () => {
        if (i == undefined) {
            if(state.create.oldAttributes == undefined) {
                state.create.oldAttributes = {...state.create.attributes};
            }

            if(state.create.oldRelations == undefined) {
                state.create.oldRelations = {...state.create.relations};
            }
        } else {
            if(state.index[i].oldAttributes == undefined) {
                state.index[i].oldAttributes = {...state.index[i].attributes};
            }

            if(state.index[i].oldRelations == undefined) {
                state.index[i].oldRelations = {...state.index[i].relations};
            }
        }
    };

    switch (action.type) {
        case 'COPY-PRODUCT':
            state.create.attributes = {...state.index[i].attributes};
            state.create.oldAttributes = {...state.init.attributes};
            state.create.relations = {...state.index[i].relations};
            state.create.oldRelations = {...state.init.relations};
            return state;
        case 'DELETE-PRODUCT':
            delete state.index.splice(i, 1);
            return state;
        case 'GET-PRODUCTS':
            return {
                ...state,
                index: action.payload.data
            };
        case 'SET-PRODUCT':
            backup();
            i = state.index.findIndex((e) => e.id === action.id );
            if (action.id == 0) {
                state.create.attributes = {...state.create.attributes, ...action.attributes}
            } else {
                if(state.index[i].oldAttributes == undefined){
                    state.index[i].oldAttributes = state.index[i].attributes;
                }
                state.index[i].attributes = { ...state.index[i].attributes, ...action.attributes };
            }

            return state;
        case 'SET-PRODUCT-TAGS':
            backup();
            var oldTags = ( i == undefined ) ? state.create.relations.tags : state.index[i].relations.tags;
            var tags = action.tags;
            oldTags.forEach(tag => {
                let add = true;
                action.taxonomy_tags.forEach(tax_tag => {
                    if (tax_tag.id == tag) add = false
                });
                if (add) tags.push(tag);
            });
            if (i==undefined) {
                state.create.relations = {...state.create.relations, tags};
            } else {
                state.index[i].relations = {...state.index[i].relations, tags};
            }
            return state;
        case 'GET-TRASH-PRODUCTS':
            return {
                ...state,
                trash: action.payload.data
            };
        case 'RESET-PRODUCT':
            if (action.id == 0) {
                state.create = {...state.init, id: 0};
            } else {
                state.index[i].attributes = {...state.index[i].oldAttributes};
                state.index[i].relations = {...state.index[i].oldRelations};
                delete state.index[i].oldAttributes;
                delete state.index[i].oldRelations;
            }
            return state;
        case 'RESTORE-PRODUCT':
            i = state.trash.findIndex((e) => e.id == action.deleted_id );
            state.trash[i].attributes.deleted_at= null;
            state.index.push(state.trash[i]);
            delete state.trash.splice(i, 1);
            return state;
        case 'SET-PRODUCT':
            backup();
            if (action.id == 0) {
                state.create.attributes = {...state.create.attributes, ...action.attributes}
            } else {
                state.index[i].attributes = { ...state.index[i].attributes, ...action.attributes };
            }
            return state;
        case 'STORE-PRODUCT':
            state.index.push(action.payload.data);
            state.create = state.init;
            return state;
        case 'UPDATE-PRODUCT':
            delete state.index[i].oldAttributes;
            delete state.index[i].oldRelations;
            return state;
        default:
            return state;
    }
}