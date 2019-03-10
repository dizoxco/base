import React, {Component} from "react";
import {connect} from "react-redux";

import {getUsers} from "../actions";
import {Button, Page, Table} from "../components";

class Users extends Component{

    componentDidMount = () => {
        if(this.props.users.length == 0) {
            this.props.getUsers();
        }
    }

    render() {
        return(
            <Page                
                title='کاربران'
                buttons = {<div>
                    <Button icon="add" type="icon" visible={!this.props.trash} onClick={() => this.props.history.push('/admin/users/create')} />
                    <Button icon="delete" type="icon" visible={!this.props.trash} onClick={() => this.props.history.push('/admin/users/trash')} />
                    <Button icon="list" type="icon" visible={this.props.trash} onClick={() => this.props.history.push('/admin/users')} />
                </div>}
            >
                <Table
                    data={this.props.users}
                    tdClick={ (row) => this.props.history.push('/admin/users/' + row.original.id)}
                    columns={[
                        {
                            Header: 'id',
                            accessor: 'id',
                            width: 150
                        },
                        {
                            Header: 'name',
                            accessor: 'attributes.name'
                        },
                        {
                            Header: 'email',
                            accessor: 'attributes.email'
                        },
                        {
                            Header: 'mobile',
                            accessor: 'attributes.mobile'
                        }
                    ]}
                />
            </Page>
        );
    }
}

const mapStateToProps = (state, props) => {
    return {
        trash: props.location.pathname == '/admin/users/trash',
        users: (props.location.pathname == '/admin/users') ? state.users.index : state.users.trash
    };
};
export default connect(mapStateToProps, {getUsers} )(Users);