import React, {Component} from "react";
import {connect} from "react-redux";

import { reduxGetter } from "../../helpers";
import {Button, Page, Table} from "../components";

class Users extends Component{

    componentDidMount = () => {
        if(this.props.users.length == 0) this.props.reduxGetter('user');
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
                            Header: 'شناسه',
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
        users: (props.location.pathname == '/admin/users/trash')? state.user.trash: state.user.index
    };
};
export default connect(mapStateToProps, { reduxGetter } )(Users);