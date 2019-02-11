import React, { Component } from "react";
import { connect } from "react-redux";

import { getBusinesses, getProducts } from "../actions"
import { Page, Icon, Table } from "../components";
import {Button} from "../components/form";

class Products extends Component{

    state = {};

    componentDidMount = () => {
        if(this.props.products.length === 1) this.props.getProducts();
        if(this.props.businesses.length === 0) this.props.getBusinesses();
    };

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
                <Button label={'Add Product'} onClick={(e) => this.props.history.push('/admin/products/0')}  />
                <Table
                    data={this.props.products.slice(1, this.props.products.length)}
                    tdClick={(r) => this.props.history.push('/admin/products/' + r.original.id)}
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
                />
            </Page>
        );
    }
}

const mapStateToProps = state => {
    return {
        products: state.products.index,
        businesses: state.businesses.index
    };
};

export default connect(mapStateToProps, { getBusinesses, getProducts })(Products);