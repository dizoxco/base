import {List} from "./components"
import {connect} from "react-redux";
import {getCookie} from "../helpers";
import React, {Component} from "react";
import {withSnackbar} from 'notistack';
import {Route, Switch, withRouter} from "react-router-dom";
import {clearRedirect, flushSnacks, logOut} from "./actions";
import {
    Business,
    Businesses,
    Comment,
    Comments,
    Dashboard,
    Login,
    MediaGroup,
    MediaGroups,
    Post,
    Posts,
    Product,
    Products,
    SearchPanel,
    SearchPanels,
    Setting,
    Tag,
    Taxonomies,
    Taxonomy,
    Tickets,
    User,
    Users
} from './pages'

class App extends Component{
    componentDidUpdate(){
        const { enqueueSnackbar  } = this.props;
        this.props.snacks.map((snack) => {
            enqueueSnackbar( snack.message, {
                variant: snack.variant,
            });
        });
        if( this.props.snacks.length ) this.props.flushSnacks();

        if (this.props.app.redirect !== null){
            this.props.history.push(this.props.app.redirect);
            this.props.clearRedirect();
        }
    }
    
    render(){
        if (getCookie('token') == null){
            return <Login />;
        } else {
            return(
                <div>
                    <div id="main-content" >
                        <Route render={({location}) => (
                                <Switch location={location}>
                                        <Route path="/admin" exact component={Dashboard} />
                                        <Route path="/admin/businesses" exact component={Businesses} />
                                        <Route path="/admin/businesses/trash" exact component={Businesses} />
                                        <Route path="/admin/businesses/:business" exact component={Business} />
                                        <Route path="/admin/comments" exact component={Comments} />
                                        <Route path="/admin/comments/:comment" exact component={Comment} />
                                        <Route path="/admin/mediagroups" exact component={MediaGroups} />
                                        <Route path="/admin/mediagroups/:mediagroup" exact component={MediaGroup} />
                                        <Route path="/admin/posts" exact component={Posts} />
                                        <Route path="/admin/posts/trash" exact component={Posts} />
                                        <Route path="/admin/posts/:post" exact component={Post} />
                                        <Route path="/admin/products" exact component={Products} />
                                        <Route path="/admin/products/trash" exact component={Products} />
                                        <Route path="/admin/products/:product" exact component={Product} />
                                        <Route path="/admin/searchpanels" exact component={SearchPanels} />
                                        <Route path="/admin/searchpanels/trash" exact component={SearchPanels} />
                                        <Route path="/admin/searchpanels/:searchpanel" exact component={SearchPanel} />
                                        <Route path="/admin/setting" exact component={Setting} />
                                        <Route path="/admin/taxonomies" exact component={Taxonomies} />
                                        <Route path="/admin/taxonomies/:taxonomy" exact component={Taxonomy} />
                                        <Route path="/admin/taxonomies/:taxonomy/tags" exact component={Tag} />
                                        <Route path="/admin/taxonomies/:taxonomy/tags/:tag" exact component={Tag} />
                                        <Route path="/admin/tickets" exact component={Tickets} />
                                        <Route path="/admin/users" exact component={Users} />
                                        <Route path="/admin/users/trash" exact component={Users} />
                                        <Route path="/admin/users/:user" exact component={User} />
                                        <Route path="/admin/login" exact component={Login} />
                                    </Switch>
                        )} />
                    </div>
                    <div id="side-nav">
                        <List
                            items={[
                                {
                                    text: 'داشبورد',
                                    link: '/admin',
                                    icon: 'dashboard'
                                },{
                                    text: 'کاربران',
                                    link: '/admin/users',
                                    icon: 'person'
                                },{
                                    text: 'مطالب',
                                    link: '/admin/posts',
                                    icon: 'edit'
                                },{
                                    text: 'کسب و کارها',
                                    link: '/admin/businesses',
                                    icon: 'business'
                                },{
                                    text: 'محصولات',
                                    link: '/admin/products',
                                    icon: 'gavel'
                                },{
                                    text: 'نظرات',
                                    link: '/admin/comments',
                                    icon: 'comment'
                                },{
                                    text: 'رسانه',
                                    link: '/admin/mediagroups',
                                    icon: 'tv'
                                },{
                                    text: 'تگ ها',
                                    link: '/admin/taxonomies',
                                    icon: 'tag'
                                },{
                                    text: 'تیکت ها',
                                    link: '/admin/tickets',
                                    icon: 'comment'
                                },{
                                    text: 'پنل جستجو',
                                    link: '/admin/searchpanels',
                                    icon: 'search'
                                },{
                                    text: 'خروج',
                                    onClick: this.props.logOut,
                                    icon: 'logout'
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
        user: state.users,
        app: state.app
    };
};

export default connect(mapStateToProps, { flushSnacks, logOut , clearRedirect })(withSnackbar(withRouter(App)));