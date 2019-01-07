import React from 'react';
import ReactDOM from 'react-dom';
import { Provider } from 'react-redux';
import { BrowserRouter, Link, Switch, Route } from "react-router-dom";
import { CSSTransition, TransitionGroup } from 'react-transition-group';
import { createStore, combineReducers, applyMiddleware, compose } from 'redux';
import thunk from 'redux-thunk';


import AppBar from '@material-ui/core/AppBar';
import Button from '@material-ui/core/Button';
import pink from '@material-ui/core/colors/pink';
import Toolbar from '@material-ui/core/Toolbar';
import { MuiThemeProvider, createMuiTheme } from '@material-ui/core/styles';

import { RTL } from "./admin/components"
import { Dashboard, Posts, Setting, Users } from './admin/pages'
import { PostReducer, UserReducer } from './admin/reducers';

const theme = createMuiTheme({
    direction: 'rtl',
    palette: {
        // type: 'dark',
        primary: pink,
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

const composeEnhancers = window.__REDUX_DEVTOOLS_EXTENSION_COMPOSE__ || compose;
const store = createStore(
                combineReducers({
                    posts: PostReducer,
                    user: UserReducer
                }),
                composeEnhancers( applyMiddleware(thunk))
            );

ReactDOM.render(
    <Provider store={store}>
        <BrowserRouter>
            <RTL>
                <MuiThemeProvider theme={theme}>
                    <AppBar position="static">
                        <Toolbar>
                            News
                            <Button color="inherit" >dd</Button>
                        </Toolbar>
                    </AppBar>
                    <div id="main-content" >
                        <Route render={({location}) => (
                            <TransitionGroup>
                                <CSSTransition
                                    key={location.key}
                                    timeout={300}
                                    classNames="fade"
                                >
                                    <Switch location={location}>
                                        <Route path="/admin" exact component={Dashboard} />
                                        <Route path="/admin/posts" exact component={Posts} />
                                        <Route path="/admin/setting" exact component={Setting} />
                                        <Route path="/admin/Users" exact component={Users} />
                                    </Switch>
                                </CSSTransition>
                            </TransitionGroup>
                        )} />
                    </div>
                    <div id="side-nav">
                        <ul>
                            <li><Link className="p-2" to="/admin">dashboard</Link></li>
                            <li><Link className="p-2" to="/admin/users">users</Link></li>
                            <li><Link className="p-2" to="/admin/posts">posts</Link></li>
                            <li><Link className="p-2" to="/admin/tickets">tickets</Link></li>
                            <li><Link className="p-2" to="/admin/setting">settings</Link></li>
                        </ul>
                    </div>
                </MuiThemeProvider>
            </RTL>
        </BrowserRouter>
    </Provider>,
    document.querySelector('#root')
);