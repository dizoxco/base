import React, { Component } from "react";
import { connect } from "react-redux";

import { getUsers } from "../actions";
import { Page, Table } from "../components";

class Users extends Component{

    componentDidMount = () => {
        this.props.getUsers();
    }

    render(){
        
        return(
            <Page                
                title='کاربران'
                button={{
                    label: 'save'
                }}
            >   
                <Table
                    data={this.props.users}
                    tdClick={ (rowInfo) => this.props.history.push('/admin/users/' + rowInfo.original.id)}
                    columns={[
                        {
                            Header: 'id',
                            accessor: 'id',
                            width: 70
                        },
                        {
                            Header: 'name',
                            accessor: 'attributes.name'
                        },
                        {
                            Header: 'email',
                            accessor: 'attributes.email'
                        }
                    ]}
                />
            </Page>
        );
    }
}

const mapStateToProps = state => {
    return {
        users: state.users.index
    };
};
export default connect(mapStateToProps, {getUsers} )(Users);