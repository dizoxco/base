import React, {Component} from "react";
import {connect} from "react-redux";

import {getBusinesses, getProducts} from "../actions"
import {Page, Table} from "../components";

class Products extends Component{

    componentDidMount = () => {
        if (this.props.products.length <= 1) {
            this.props.getProducts();
        }
        if(this.props.businesses.length == 0) this.props.getBusinesses();
    };

    render() {
        return(
            <Page
                title='محصولات'
                button={{
                    label: 'محصول جدید',
                    onClick: () => this.props.history.push('/admin/products/create')
                }}
            >
                <Table
                    data={this.props.products}
                    tdClick={(r) => this.props.history.push('/admin/products/' + r.original.id)}
                    columns={[
                        {
                            Header: 'id',
                            accessor: 'id',
                            width: 100
                        },
                        {
                            Header: 'عنوان',
                            width: 500,
                            accessor: 'attributes.title',
                        },
                        {
                            Header: 'خلاصه',
                            width: 500,
                            accessor: 'attributes.abstract',
                        },
                        {
                            Header: 'قیمت',
                            width: 200,
                            accessor: 'attributes.price',
                        },
                        {
                            Header: 'وضعیت',
                            width: 100,
                            accessor: 'attributes.status',
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