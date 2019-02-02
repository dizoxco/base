import React from 'react';
import ReactDOM from 'react-dom';
import { Provider } from 'react-redux';
import { BrowserRouter, Link, Redirect, Switch, Route } from "react-router-dom";

import { createStore, combineReducers, applyMiddleware, compose } from 'redux';
import thunk from 'redux-thunk';


import pink from '@material-ui/core/colors/pink';
import Toolbar from '@material-ui/core/Toolbar';
import { MuiThemeProvider, createMuiTheme } from '@material-ui/core/styles';

import { List, RTL } from "./admin/components"
import { Dashboard, Login, Posts, Setting, Users } from './admin/pages'
import { BusinessReducer, CommentReducer, ProductReducer, PostReducer, SnackReducer, TicketReducer, UserReducer } from './admin/reducers';

import App from './admin/App';

import { SnackbarProvider } from 'notistack';

const composeEnhancers = window.__REDUX_DEVTOOLS_EXTENSION_COMPOSE__ || compose;
const store = createStore(
                combineReducers({
                    businesses: BusinessReducer,
                    comments: CommentReducer,
                    posts: PostReducer,
                    products: ProductReducer,
                    snacks: SnackReducer,
                    tickets: TicketReducer,
                    users: UserReducer
                }),
                composeEnhancers( applyMiddleware(thunk))
            );
const theme = createMuiTheme({
    direction: 'rtl',
    palette: {
        // type: 'dark',
        // primary: pink,
    },
    typography: {
        fontFamily: [
            "Roboto",
            "-apple-system",
            "BlinkMacSystemFont",
            "Segoe UI",
            "Arial",
            "sans-serif"
        ].join(","),
        useNextVariants: true
    }
});
ReactDOM.render(
    <Provider store={store}>
        <BrowserRouter>
            <RTL>
                <MuiThemeProvider theme={theme}>
                    <Route render={({location}) => (
                        <SnackbarProvider 
                            maxSnack={5} 
                            anchorOrigin={{vertical: 'top', horizontal: 'left'}}
                            action={[<span style={{color: "red"}}>X</span>]}
                        >
                            <App location={location} />
                        </SnackbarProvider>
                    )} />
                </MuiThemeProvider>
            </RTL>
        </BrowserRouter>
    </Provider>,
    document.querySelector('#root')
);