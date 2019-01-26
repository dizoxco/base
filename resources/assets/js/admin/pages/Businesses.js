import React, { Component } from "react";
import { connect } from "react-redux";

import { getBusinesses } from "../actions"
import { Page, Icon, Table } from "../components";

class Businesses extends Component{

    state = {}

    componentDidMount = () => {
        if(this.props.businesses.length == 0) this.props.getBusinesses();
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
                    data={this.props.businesses}
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
                            accessor: 'attributes.brand',
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
        businesses: state.business.businesses
    };
};

export default connect(mapStateToProps, { getBusinesses })(Businesses);