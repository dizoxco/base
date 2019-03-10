import React, {Component} from "react";
import {connect} from "react-redux";

import {getPosts, getUsers} from "../actions"
import {Button, Page, Table} from "../components";

class Posts extends Component{

    state = {}

    componentDidMount = () => {
        if(this.props.posts.length == 0) {
            this.props.getPosts();
        }
        if(this.props.users.length == 0) this.props.getUsers();
    }

    render(){
        return(
            <Page                
                title='مطالب'
                buttons = {<div>
                    <Button icon="add" type="icon" visible={!this.props.trash} onClick={() => this.props.history.push('/admin/posts/create')} />
                    <Button icon="delete" type="icon" visible={!this.props.trash} onClick={() => this.props.history.push('/admin/posts/trash')} />
                    <Button icon="list" type="icon" visible={this.props.trash} onClick={() => this.props.history.push('/admin/posts')} />
                </div>}
            >   
                <Table
                    data={this.props.posts}
                    tdClick={(r) => this.props.history.push('/admin/posts/' + r.original.id)}
                    columns={[
                        {
                            Header: 'id',
                            accessor: 'id',
                            width: 70
                        },
                        {
                            Header: 'عنوان',
                            Cell: row => row.original.oldAttributes? <strong>{row.original.attributes.title}</strong>: <span>{row.original.attributes.title}</span>
                        },
                        {
                            Header: 'نویسنده',
                            width: 200,
                            Cell: (row) => {
                                var user = this.props.users.find( e => e.id == row.original.attributes.user_id );
                                return (
                                    <div>{ user? user.attributes.name: '...' }</div>
                                )
                            }
                        }
                    ]}
                />
            </Page>
        );
    }
}

const mapStateToProps = (state, props) => {
    return {
        trash: props.location.pathname == '/admin/posts/trash',
        posts: (props.location.pathname == '/admin/posts')? state.posts.index: state.posts.trash,
        users: state.users.index
    };
};

export default connect(mapStateToProps, { getPosts, getUsers })(Posts);