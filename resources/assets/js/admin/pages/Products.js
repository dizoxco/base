import React, {Component} from "react";
import {connect} from "react-redux";

import {getProducts} from "../actions"
import {Button, Page, Table} from "../components";

class Products extends Component{

    componentDidMount = () => {
        if (this.props.products.length <= 1) {
            this.props.getProducts();
        }
    };

    render() {
        return(
            <Page
                title='محصولات'
                buttons = {<div>
                    <Button icon="add" type="icon" visible={!this.props.trash} onClick={() => this.props.history.push('/admin/products/create')} />
                    <Button icon="delete" type="icon" visible={!this.props.trash} onClick={() => this.props.history.push('/admin/products/trash')} />
                    <Button icon="list" type="icon" visible={this.props.trash} onClick={() => this.props.history.push('/admin/products')} />
                </div>}
            >
                <Table
                    data={this.props.products}
                    tdClick={(r) => this.props.history.push('/admin/products/' + r.original.id)}
                    columns={[
                        {
                            Header: 'شناسه',
                            accessor: 'id',
                            width: 150
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

const mapStateToProps = (state, props) => {
    return {
        trash: props.location.pathname == '/admin/products/trash',
        products: (props.location.pathname == '/admin/products') ? state.products.index : state.products.trash
    };
};

export default connect(mapStateToProps, { getProducts })(Products);