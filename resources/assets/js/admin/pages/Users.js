import React, { Component } from "react";
import { connect } from "react-redux";

import { getUsers } from "../actions";
import { Page, Table ,Icon} from "../components";
import {Button} from "../components/form";

class Users extends Component{

    state = {}
    componentDidMount = () => {
        if(this.props.users.length == 0)
            this.props.getUsers();
    }

    render(){ 
        
        return(
            <Page                
                title='کاربران'
                // button={{
                //     label: 'save'
                // }}
                button={{
                    label: 'add new User',
                    onClick: () => this.props.history.push('/admin/users/create')
                }}
            >
                {/* <Button label={'Add user'} onClick={(e) => this.props.history.push('/admin/users/0')}  /> */}
                <Table
                    data={this.props.users}
                    // data={this.props.users.slice(1, this.props.users.length)}
                    tdClick={ (rowInfo) => this.props.history.push('/admin/users/' + rowInfo.original.id)}
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