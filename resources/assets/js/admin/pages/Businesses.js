import React, { Component } from "react";
import { connect } from "react-redux";

import { getBusinesses, getPosts, getUsers } from "../actions"
import { Page, Icon, Table } from "../components";

class Businesses extends Component{

    state = {}

    componentDidMount = () => {
        getBusinesses();
        if(this.props.posts.length == 0) this.props.getPosts();
        if(this.props.users.length == 0) this.props.getUsers();
    }

    tdClick = (rowInfo) => {
        this.setState({
            redirect: '/admin/posts/' + rowInfo.original.id
        })
    }

    render(){
        return(
            <Page                
                title='کسب و کارها'
                button={{
                    label: 'save'
                }}
                redirect={this.state.redirect}
                onChange={(value) => this.setState({tab: value})}
            >   
                <Table
                    data={this.props.posts}
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
                    tdClick={this.tdClick}
                />
            </Page>
        );
    }
}

const mapStateToProps = state => {
    return {
        businesses: state.posts.businesses,
        posts: state.posts.posts,
        users: state.users.users
    };
};

export default connect(mapStateToProps, { getBusinesses, getPosts, getUsers })(Businesses);