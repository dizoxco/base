import React from 'react';
import ReactDOM from 'react-dom';
import { Provider } from 'react-redux';
import { createStore, applyMiddleware } from 'redux';
import { BrowserRouter, Link, Route } from "react-router-dom";

import Dashboard from './admin/pages/Dashboard'
import Posts from './admin/pages/Posts';
import Setting from './admin/pages/Setting';

// const store = createStore(reducers, applyMiddleware(thunk));
// alert('dd');
ReactDOM.render(
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
    </BrowserRouter>,
    document.querySelector('#root')
);