import React from 'react';
import ReactDOM from 'react-dom';
import { Provider } from 'react-redux';
import { BrowserRouter, Link, Route } from "react-router-dom";
import { createStore, applyMiddleware, compose } from 'redux';
import thunk from 'redux-thunk';

import PostReducer from './admin/reducers/PostReducer';

import Dashboard from './admin/pages/Dashboard'
import Posts from './admin/pages/Posts';
import Setting from './admin/pages/Setting';

const composeEnhancers = window.__REDUX_DEVTOOLS_EXTENSION_COMPOSE__ || compose;
const store = createStore(PostReducer, composeEnhancers( applyMiddleware(thunk)));

ReactDOM.render(
    <Provider store={store}>
        <BrowserRouter>
            <div>
                <div className="text-center">
                    <Link className="p-2" to="/admin">dashboard</Link>
                    <Link className="p-2" to="/admin/users">users</Link>
                    <Link className="p-2" to="/admin/posts">posts</Link>
                    <Link className="p-2" to="/admin/tickets">tickets</Link>
                    <Link className="p-2" to="/admin/setting">settings</Link>
                </div>
                <Route path="/admin" exact component={Dashboard} />
                <Route path="/admin/posts" exact component={Posts} />
                <Route path="/admin/setting" exact component={Setting} />
            </div>
        </BrowserRouter>
    </Provider>,
    document.querySelector('#root')
);