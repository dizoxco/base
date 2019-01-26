import React, { Component } from "react";
import { connect } from "react-redux";

import { getBusinesses, getProducts } from "../actions"
import { Page, Icon, Table } from "../components";

class Products extends Component{

    state = {}

    componentDidMount = () => {
        if(this.props.products.length == 0) this.props.getProducts();
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
                title='محصولات'
                button={{
                    label: 'save'
                }}
                redirect={this.state.redirect}
                onChange={(value) => this.setState({tab: value})}
            >   
                <Table
                    data={this.props.products}
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
        products: state.products.products,
        businesses: state.business.businesses
    };
};

export default connect(mapStateToProps, { getBusinesses, getProducts })(Products);