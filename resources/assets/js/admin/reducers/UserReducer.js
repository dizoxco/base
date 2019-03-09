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
export const UserReducer = (state = initialState, action) => {
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
        case 'COPY-USER':
            state.create.attributes = {...state.index[i].attributes};
            state.create.oldAttributes = {...state.init.attributes};
            state.create.relations = {...state.index[i].relations};
            state.create.oldRelations = {...state.init.relations};
            return state;
        case 'DELETE-USER':
            delete state.index.splice(i, 1);
            return state;
        case 'GET-USERS':
            return {
                ...state,
                index: action.payload.data
            };
        case 'GET-TRASH-USERS':
            return {
                ...state,
                trash: action.payload.data
            };
        case 'LOGOUT':
            return {
                ...state,
                token: null
            };
        case 'RESET-USER':
            if (action.id == 0) {
                state.create = {...state.init, id: 0};
            } else {
                state.index[i].attributes = {...state.index[i].oldAttributes};
                state.index[i].relations = {...state.index[i].oldRelations};
                delete state.index[i].oldAttributes;
                delete state.index[i].oldRelations;
            }
            return state;
        case 'RESTORE-USER':
            i = state.trash.findIndex((e) => e.id == action.deleted_id );
            state.trash[i].attributes.deleted_at= null;
            state.index.push(state.trash[i]);
            delete state.trash.splice(i, 1);
            return state;            
        case 'SET-USER':
            backup();
        if (action.id == 0) {
            state.create.attributes = {...state.create.attributes, ...action.attributes}
        } else {
            state.index[i].attributes = { ...state.index[i].attributes, ...action.attributes };
        }
        return state;
        case 'STORE-USER':
            state.index.push(action.payload.data);
            state.create = state.init;
            return state;
        case 'TOKEN':
            return {
                ...state,
                token: action.payload.access_token
            };
        case 'UPDATE-USER':
            delete state.index[i].oldAttributes;
            delete state.index[i].oldRelations;
            return state;
        default:
            return state;
    }
}