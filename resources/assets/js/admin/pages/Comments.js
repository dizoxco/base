import React, { Component } from "react";
import { connect } from "react-redux";

import { getBusinesses, getProducts, getComments } from "../actions"
import { Page, Icon, Table } from "../components";

class Businesses extends Component{

    state = {}

    componentDidMount = () => {
        if(this.props.comments.length == 0) this.props.getComments();
    }

    tdClick = (rowInfo) => {
        this.props.history.push('/admin/comments/' + rowInfo.original.id);
    }

    render(){
        return(
            <Page                
                title='نظرات'
                button={{
                    label: 'save'
                }}
                redirect={this.state.redirect}
                onChange={(value) => this.setState({tab: value})}
            >   
                <Table
                    data={this.props.comments}
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
                            accessor: 'attributes.body',
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
        comments: state.comments.index
    };
};

export default connect(mapStateToProps, { getBusinesses, getProducts, getComments })(Businesses);