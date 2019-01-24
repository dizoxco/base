import React, { Component } from "react";

import { CSSTransition, TransitionGroup } from 'react-transition-group';

import { BrowserRouter, Link, Redirect, Switch, Route } from "react-router-dom";


import AppBar from '@material-ui/core/AppBar';
import Button from '@material-ui/core/Button';

import Toolbar from '@material-ui/core/Toolbar';


import { List, RTL } from "./components"
import { Dashboard, Login, Post, Posts, Setting, Users } from './pages'

import { withSnackbar } from 'notistack';
import { connect } from "react-redux";

import { flushSnacks } from "./actions";
import { eraseCookie, getCookie } from "../helpers";

class App extends Component{
    componentDidUpdate(){
        
        
        

        const { enqueueSnackbar } = this.props;
        this.props.snacks.map((snack) => {
            enqueueSnackbar( snack.message, {
                variant: snack.variant,
            });
        });
        if( this.props.snacks.length ) this.props.flushSnacks();
    }

    logOut = () => {
        this.setState({ 'update': 'dd' })
        eraseCookie('token');
    }
    
    render(){
        
        
        // if (!this.props.user.token) return <Redirect to="/admin/login" />;
        // if (this.props.location.pathname == '/admin/login'){
            // return <Login />;
        if (getCookie('token') == null){
            return <Login />;
        } else {
            return(
                <div>
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
                                        <Route path="/admin/posts/:user" exact component={Post} />
                                        <Route path="/admin/setting" exact component={Setting} />
                                        <Route path="/admin/Users" exact component={Users} />
                                        <Route path="/admin/login" exact component={Login} />
                                    </Switch>
                                </CSSTransition>
                            </TransitionGroup>
                        )} />
                    </div>
                    <div id="side-nav">
                        <List
                            items={[
                                {
                                    text: 'داشبورد',
                                    link: '/admin',
                                    icon: 'add'
                                },{
                                    text: 'کاربران',
                                    link: '/admin/users',
                                    icon: 'add'
                                },{
                                    text: 'مطالب',
                                    link: '/admin/posts',
                                    icon: 'add'
                                },{
                                    text: 'تنظیمات',
                                    link: '/admin/setting',
                                    icon: 'add'
                                },{
                                    text: 'تیکت ها',
                                    link: '/admin/tickets',
                                    icon: 'add'
                                },{
                                    text: 'خروج',
                                    // link: '/admin/login',
                                    onClick: this.logOut,
                                    icon: 'add'
                                }
                            ]}
                        />
                    </div>
                </div>
            );
        }
    }
}

const mapStateToProps = state => {
    return {
        snacks: state.snacks,
        user: state.users
    };
};

export default connect(mapStateToProps, { flushSnacks })(withSnackbar(App));