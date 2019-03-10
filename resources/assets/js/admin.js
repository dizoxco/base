import React from 'react';
import App from './admin/App';
import thunk from 'redux-thunk';
import ReactDOM from 'react-dom';
import {Provider} from 'react-redux';
import {RTL} from "./admin/components"
import {SnackbarProvider} from 'notistack';
import {BrowserRouter, Route} from "react-router-dom";
import {createMuiTheme, MuiThemeProvider} from '@material-ui/core/styles';
import {applyMiddleware, combineReducers, compose, createStore} from 'redux';

import {
    AppReducer,
    BusinessReducer,
    CityReducer,
    CommentReducer,
    MediaReducer,
    PostReducer,
    ProductReducer,
    SearchPanelReducer,
    SnackReducer,
    TagReducer,
    TaxonomyReducer,
    TicketReducer,
    UserReducer,
} from './admin/reducers';

const composeEnhancers = window.__REDUX_DEVTOOLS_EXTENSION_COMPOSE__ || compose;
const store = createStore(
                combineReducers({
                    businesses: BusinessReducer,
                    cities: CityReducer,
                    comments: CommentReducer,
                    posts: PostReducer,
                    media: MediaReducer,
                    products: ProductReducer,
                    snacks: SnackReducer,
                    searchpanels: SearchPanelReducer,
                    tickets: TicketReducer,
                    users: UserReducer,
                    tags: TagReducer,
                    taxonomies: TaxonomyReducer,
                    app: AppReducer,
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
                            anchorOrigin={{vertical: 'bottom', horizontal: 'left'}}
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