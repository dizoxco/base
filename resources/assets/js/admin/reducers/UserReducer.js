import {StaticRouter } from 'react-router-dom'
const initialState = {
    token: null,
    user: null,
    index: [{id:0,attributes:{}}],
    init:{id:0,attributes:{}}
};
export const UserReducer = (state = initialState, action) => {
    switch (action.type) {
        case 'GET-USERS':
            return {
                ...state,
                index: state.index.concat(action.payload.data)
            };
        case 'SET-USER':
            let i = state.index.findIndex((e) => e.id === action.id);
            if (state.index[i].oldAttributes === undefined) {
                state.index[i].oldAttributes = state.index[i].attributes;
            }
            state.index[i].attributes = {...state.index[i].attributes, ...action.attributes};
            return state;
        case 'TOKEN':
            return {
                ...state,
                token: action.payload.access_token
            };
        case 'LOGOUT':
            return {
                ...state,
                token: null
            };
        case 'STORE-USER':
            state.index.splice(1,0,action.payload.data); // for testing
            // state.index.push(action.payload.data); //real code
            state.index[0].attributes = state.index[0].oldAttributes;
            delete state.index[0].oldAttributes;
            return state;
        case 'UPDATE-USER':
            let updatedIndex = state.index.findIndex((e) => e.id === action.payload.data.id);
            state.index[updatedIndex].attributes = action.payload.data.attributes;
            delete state.index[updatedIndex].oldAttributes;
        default:
            return state;
    }
}