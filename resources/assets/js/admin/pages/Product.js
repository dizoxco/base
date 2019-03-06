import React, { Component } from "react";
import { connect } from "react-redux";

import { getTaxonomies, getTags, getProducts, setProduct, setProductTags ,updateProduct, storeProduct } from "../actions"
import {Form, Page, Show, Table, Text, NotFound, AutoComplete} from "../components";

class Product extends Component{

    state = {tab: 1};

    componentDidMount(){
        if (this.props.product.id === undefined) {
            this.props.getProducts();
        }
        if (this.props.tags.length == 0) {
            this.props.getTags();
        }
    }

    handleClick = () => {
        if (this.props.product.id == 0) {
            this.props.storeProduct(this.props.product)
        } else {
            this.props.updateProduct(this.props.product)
        }
    };

    render(){
        if (this.props.product === null) return <Loading />
        if (this.props.product === undefined) return <NotFound />
        return(
            <Page                
                title={this.props.product.attributes.title}
                button={{
                    label: 'save',
                    onClick:() => this.handleClick()
                }}
                tabs={this.props.product.id === 0 ?['نمایش','افزودن محصول'] :['نمایش', 'ویرایش اطلاعات', 'نظرات']}
                tab={this.state.tab}
                redirect={this.state.redirect}
                loading={this.props.product == null}
                onChange={(tab) => this.setState({tab})}
            >
                <Form show={this.state.tab === 0}>
                    <Show data={[
                        { label: 'نامک',        value: this.props.product.attributes.slug},
                    ]} />
                </Form>
                <Form show={this.state.tab === 1}>
                    <Text
                        label='نام'
                        value={this.props.product.attributes.title}
                        half
                        onChange={ (e) => this.props.setProduct(this.props.product.id, {title: e.target.value}) }
                    />
                    <Text
                        label='نامک'
                        value={this.props.product.attributes.slug}
                        half
                        onChange={ (e) => this.props.setProduct(this.props.product.id, {slug: e.target.value}) }
                    />
                    <Text
                        label='خلاصه'
                        value={this.props.product.attributes.abstract}
                        half
                        onChange={ (e) => this.props.setProduct(this.props.product.id, {abstract: e.target.value}) }
                    />
                    <Text
                        label='توضیحات'
                        value={this.props.product.attributes.body}
                        half
                        onChange={ (e) => this.props.setProduct(this.props.product.id, {body: e.target.value}) }
                    />
                    <Text
                        label='قیمت'
                        value={this.props.product.attributes.price}
                        half
                        type={'number'}
                        onChange={ (e) => this.props.setProduct(this.props.product.id, {price: e.target.value}) }
                    />
                    <AutoComplete
                        data = {this.props.tags}
                        accessors= {{
                            value: 'id',
                            label: 'attributes.fullname'
                        }}
                        value = {this.props.product.relations.tags}
                        onChange = {(tags) => this.props.setProductTags(this.props.product.id, tags, this.props.tags)}
                    />
                </Form>
                <Form show={this.state.tab === 2}>
                    <Table
                        data={this.props.comments}
                        columns={[
                            {
                                Header: 'id',
                                accessor: 'id',
                                width: 150
                            },
                            {
                                Header: 'وضعیت',
                                width: 200,
                                Cell: row => row.original.oldAttributes? (<Icon icon="edit" />): '',
                            },
                            {
                                Header: 'عنوان',
                                accessor: 'attributes.body',
                            }
                        ]}
                        tdClick={this.tdClick}
                    />
                </Form>
            </Page>
        );
    }
}

const mapStateToProps = (state, props) => {
    let product;
    let tags;

    tags = state.tags.index.filter(tag => tag.attributes.taxonomy_group_name == 'product');

    if (props.match.params.product == 'create') {
        product = state.product.create;
    }

    if (state.products.index.length == 0) {
        product = state.products.init;
    }

    if (!product) {
        product = state.products.index.find( element => element.id == props.match.params.product );
    }

    return {product, tags};
};

export default connect(
    mapStateToProps,
    { getTaxonomies, getTags, getProducts ,setProduct, setProductTags, updateProduct , storeProduct }
    )(Product);