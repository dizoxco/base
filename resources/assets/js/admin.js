import React from 'react';
import ReactDOM from 'react-dom';
import { Provider } from 'react-redux';
import { BrowserRouter, Route } from "react-router-dom";

import { createStore, combineReducers, applyMiddleware, compose } from 'redux';
import thunk from 'redux-thunk';

import { MuiThemeProvider, createMuiTheme } from '@material-ui/core/styles';

import { List, RTL } from "./admin/components"

import {
    BusinessReducer,
    CommentReducer,
    MediaReducer,
    ProductReducer,
    PostReducer,
    SnackReducer,
    SearchPanelReducer,
    TicketReducer,
    UserReducer,
    AppReducer,
    TaxonomyReducer
} from './admin/reducers';

import App from './admin/App';

import { SnackbarProvider } from 'notistack';

const composeEnhancers = window.__REDUX_DEVTOOLS_EXTENSION_COMPOSE__ || compose;
const store = createStore(
                combineReducers({
                    businesses: BusinessReducer,
                    comments: CommentReducer,
                    posts: PostReducer,
                    media: MediaReducer,
                    products: ProductReducer,
                    snacks: SnackReducer,
                    searchpanels: SearchPanelReducer,
                    tickets: TicketReducer,
                    users: UserReducer,
                    taxonomies: TaxonomyReducer,
                    app: AppReducer
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