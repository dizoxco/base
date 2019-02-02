import React, { Component } from "react";
import { connect } from "react-redux";

import { getPosts, setPost, updatePost } from "../actions"
import { Loading, NotFound, Table, Form, Page, Show, Text } from "../components";

class Post extends Component{

    state = {        
        tab: 0
    }

    componentDidMount(){
        if (this.props.post === null) {
            this.props.getPosts();
        }
    }


    render(){
        if (this.props.post === null) return <Loading />
        if (this.props.post === undefined) return <NotFound />
        return(
            <Page                
                // title={this.props.post.attributes.title}
                title={this.props.post.attributes.title}
                button={{
                    label: 'save',
                    onClick: () => this.props.updatePost(this.props.post)
                }}
                tabs={['نمایش', 'ویرایش اطلاعات', 'نظرات']}
                tab={this.state.tab}
                redirect={this.state.redirect}
                loading={this.props.post == null}
                onChange={(tab) => this.setState({tab})}
            >
                <Form show={this.state.tab == 0}>
                    <Show data={[
                        { label: 'عنوان',       value: this.props.post.attributes.title},
                        { label: 'نامک',        value: this.props.post.attributes.slug},
                        { label: 'چکیده',       value: this.props.post.attributes.abstract},
                        { label: 'محتوا',       value: this.props.post.attributes.body},
                    ]} />
                </Form>
                <Form show={this.state.tab == 1}>
                    <Text
                        label='عنوان'
                        value={this.props.post.attributes.title}
                        half
                        onChange={ (e) => this.props.setPost(this.props.post.id, {title: e.target.value}) }
                    />
                    <Text
                        label='نامک'
                        value={this.props.post.attributes.slug}
                        half
                        onChange={ (e) => this.props.setPost(this.props.post.id, {slug: e.target.value}) }
                    />
                    <Text
                        label='چکیده'
                        name='aaa'
                        value={this.props.post.attributes.abstract}
                        onChange={ (e) => this.props.setPost(this.props.post.id, {abstract: e.target.value}) }
                    />
                    <Text
                        label='محتوا'
                        value={this.props.post.attributes.body}
                        onChange={ (e) => this.props.setPost(this.props.post.id, {body: e.target.value}) }
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
        post: (state.posts.index.length)?
            state.posts.index.find( element => element.id == props.match.params.post ):
            null,
        comments: state.comments.index
    };
};

export default connect(mapStateToProps, { getPosts, setPost, updatePost })(Post);