import React, {Component} from "react";
import {connect} from "react-redux";

import {
    copyProduct,
    deleteProduct,
    getProducts,
    getTags,
    getTaxonomies,
    resetProduct,
    restoreProduct,
    setProduct,
    setProductTags,
    storeProduct,
    updateProduct
} from "../actions"
import {AutoComplete, Button, Checkbox, Form, Page, Show, Table, Text} from "../components";

class Product extends Component{

    state = {activeTabIndex: 1};

    componentDidMount() {
        if (this.props.product != undefined) {
            if (this.props.product.id == undefined || this.props.product.attributes == undefined) {
                this.props.getProducts();
            }
            if (this.props.tags.length == 0) {
                this.props.getTags();
            }            
        }        
    }

    render() {
        return (
            <Page                
                title={this.props.product.attributes.title}
                buttons={<div>
                    <Button
                        type="icon"
                        icon="save"
                        visible={!this.props.trashed}
                        disabled={!this.props.edited}
                        onClick={() => this.props.product.id? this.props.updateProduct(this.props.product) : this.props.storeProduct(this.props.product)}
                    />
                    <Button
                        type="icon"
                        icon="restore"
                        disabled={!(this.props.edited || this.props.trashed) }
                        onClick={() => this.props.trashed ?
                            this.props.restoreProduct(this.props.product.id):
                            this.props.resetProduct(this.props.product.id)
                        }
                    />
                    <Button
                        type="icon"
                        icon="delete"
                        visible={!this.props.trashed}
                        onClick={() => this.props.deleteProduct(this.props.product.id, () => this.props.history.push('/admin/products'))}
                    />
                    <Button
                        type="icon"
                        icon="file_copy"
                        onClick={() => this.props.copyProduct(this.props.product.id, () => this.props.history.push('/admin/products/create'))}
                        visible={this.props.product.id && !this.props.trashed}
                    />
                </div>}
                tabs={
                    this.props.product.id === 0 ? ['نمایش','افزودن محصول'] : ['نمایش', 'ویرایش اطلاعات', 'نظرات']
                }
                tab={this.state.activeTabIndex}
                redirect={this.state.redirect}
                loading={this.props.product == null}
                onChange={(activeTabIndex) => this.setState({activeTabIndex})}
            >
                {/* Show product */}
                <Form show={this.state.activeTabIndex == 0}>
                    <Show label="عنوان">{this.props.product.attributes.title}</Show>
                    <Show label="نامک">{this.props.product.attributes.slug}</Show>
                    <Show label="تاریخ عرضه">{this.props.product.attributes.available_at}</Show>
                    <Show label="چکیده" full>{this.props.product.attributes.abstract}</Show>
                    <Show label="بدنه" full>{this.props.product.attributes.body}</Show>
                    <Show label="قیمت" full>{this.props.product.attributes.price}</Show>
                </Form>

                {/* Show and create product */}
                <Form show={this.state.activeTabIndex === 1}>
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
                    <Checkbox
                        checked={false}
                        value="1"
                        label="Single"
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

                {/* Product's comments */}
                <Form show={this.state.activeTabIndex === 2}>
                    <Table
                        data={this.props.comments}
                        columns={[
                            {
                                Header: 'user_id',
                                accessor: 'attributes.user_id',
                                width: 150
                            },
                            {
                                Header: 'نظر',
                                width: 200,
                                accessor: 'attributes.body',
                            },
                            {
                                Header: 'stat',
                                width: 150,
                                accessor: 'attributes.stat',
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
    let id = props.match.params.product;

    if (id == 'create') {
        product = state.products.create;
    } else if (state.products.index.length == 0) {
        product = state.products.init;
    } else {
        product = state.products.index.find( element => element.id == id );
    }

    if (product == undefined) {
        product = state.products.trash.find( element => element.id == id );
    }

    let tags = state.tags.index.filter(tag => tag.attributes.taxonomy_group_name == 'product');
    let trashed = ( product != undefined && product.attributes.deleted_at != null);
    let edited = ( product != undefined && (product.oldAttributes != undefined || product.oldRelations != undefined));

    return {product, trashed, edited, tags};
};

export default connect(
    mapStateToProps,
    {
        copyProduct,
        deleteProduct,
        getProducts,
        getTags,
        getTaxonomies,
        resetProduct,
        restoreProduct,
        setProduct,
        setProductTags,
        storeProduct,
        updateProduct
    }
    )(Product);