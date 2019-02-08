import React, { Component } from "react";
import { connect } from "react-redux";

import { getPosts, getUsers, setPost, updatePost } from "../actions"
import { Loading, NotFound, Table, Form, Editor, Page, Show, Text } from "../components";

class Post extends Component{

    state = {        
        tab: 1
    }

    componentDidMount(){
        if (this.props.post === null) this.props.getPosts();
        
    }

    render(){
        
        console.log(this.props.post);
        if (this.props.post === null) return <Loading />
        if (this.props.post === undefined) return <NotFound />
        if (this.props.author === null) this.props.getUsers();
        
        return(
            <Page                
                title={this.props.post.attributes.title}
                button={{
                    label: 'save',
                    onClick: () => this.props.updatePost(this.props.post)
                }}
                tabs={['نمایش', 'ویرایش اطلاعات']}
                tab={this.state.tab}
                redirect={this.state.redirect}
                loading={this.props.post == null}
                onChange={(tab) => this.setState({tab})}
            >
                <Form show={this.state.tab == 0}>
                    <Show label="عنوان">{this.props.post.attributes.title}</Show>
                    <Show label="نامک">{this.props.post.attributes.slug}</Show>
                    <Show label="نویسنده">{this.props.author? this.props.author.attributes.name: '...'}</Show>
                    <Show label="منتشر شده در">{this.props.post.attributes.published_at}</Show>
                    <Show label="چکیده" full>{this.props.post.attributes.abstract}</Show>
                    <Show label="بدنه" full>{this.props.post.attributes.body}</Show>
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
                    <Editor />
                </Form>
            </Page>
        );
    }
}

const mapStateToProps = (state, props) => {
    let post = (state.posts.index.length)?
                state.posts.index.find( element => element.id == props.match.params.post ):
                null;
    return { 
        post,
        author: (state.users.index.length && post.id)?
            state.users.index.find( element => element.id == post.id ):
            null,
        comments: state.comments.index
    };
};

export default connect(mapStateToProps, { getPosts, getUsers, setPost, updatePost })(Post);