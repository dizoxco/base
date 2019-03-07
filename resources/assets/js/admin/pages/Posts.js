import React, { Component } from "react";
import { connect } from "react-redux";

import { getPosts, getUsers } from "../actions"
import { Page, Icon, Table, Button } from "../components";

class Posts extends Component{

    state = {}

    componentDidMount = () => {
        if(this.props.posts.length == 0) this.props.getPosts();
        if(this.props.users.length == 0) this.props.getUsers();
    }

    render(){
        return(
            <Page                
                title='مطالب'
                buttons = {<Button icon="add" type="icon" onClick={() => this.props.history.push('/admin/posts/create')} />}
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
                            Header: 'وضعیت',
                            width: 50,
                            Cell: row => row.original.oldAttributes? (<Icon icon="edit" />): '',
                        },
                        {
                            Header: 'عنوان',
                            accessor: 'attributes.title',
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

const mapStateToProps = state => {
    return {
        posts: state.posts.index,
        users: state.users.index
    };
};

export default connect(mapStateToProps, { getPosts, getUsers })(Posts);