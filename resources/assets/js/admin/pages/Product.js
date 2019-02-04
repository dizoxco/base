import React, { Component } from "react";
import { connect } from "react-redux";

import { getProducts, setPost, updatePost } from "../actions"
import { Loading, NotFound, Table, Form, Page, Show, Text } from "../components";

class Product extends Component{

    state = {        
        tab: 0
    }

    componentDidMount(){
        if (this.props.product === null) {
            this.props.getProducts();
        }
    }


    render(){
        if (this.props.product === null) return <Loading />
        if (this.props.product === undefined) return <NotFound />
        return(
            <Page                
                title={this.props.product.attributes.title}
                button={{
                    label: 'save',
                    onClick: updatePost(this.props.product)
                }}
                tabs={['نمایش', 'ویرایش اطلاعات', 'نظرات']}
                tab={this.state.tab}
                redirect={this.state.redirect}
                loading={this.props.product == null}
                onChange={(tab) => this.setState({tab})}
            >
                <Form show={this.state.tab == 0}>
                    <Show data={[
                        { label: 'نامک',        value: this.props.product.attributes.slug},
                    ]} />
                </Form>
                <Form show={this.state.tab == 1}>
                    <Text
                        label='نامک'
                        value={this.props.product.attributes.slug}
                        half
                        onChange={ (e) => this.props.setPost(this.props.product.id, {slug: e.target.value}) }
                    />
                </Form>
                <Form show={this.state.tab == 2}>
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
                </Form>
            </Page>
        );
    }
}

const mapStateToProps = (state, props) => {
    return { 
        product: (state.products.index.length)?
            state.products.index.find( element => element.id == props.match.params.product ):
            null,
        comments: state.comments.index
    };
};

export default connect(mapStateToProps, { getProducts })(Product);