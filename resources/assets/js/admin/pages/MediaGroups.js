import React, { Component } from "react";
import { connect } from "react-redux";

import { getMediaGroups, getPosts, getUsers } from "../actions"
import { Page, Icon, Table } from "../components";

class MediaGroups extends Component{

    state = {}

    componentDidMount = () => {
        if(this.props.mediagroups.length == 0) this.props.getMediaGroups();
    }

    render(){
        return(
            <Page                
                title='رسانه'
                button={{
                    label: 'save'
                }}
                onChange={(value) => this.setState({tab: value})}
            >   
                <Table
                    data={this.props.mediagroups}
                    tdClick={(r) => this.props.history.push('/admin/mediagroups/' + r.original.id)}
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
                            accessor: 'attributes.name',
                        },
                    ]}
                />
            </Page>
        );
    }
}

const mapStateToProps = state => {
    return {
        mediagroups: state.media.mediagroups,
    };
};

export default connect(mapStateToProps, { getMediaGroups, getPosts, getUsers })(MediaGroups);