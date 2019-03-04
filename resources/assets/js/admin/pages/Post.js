import React, { Component } from "react";
import { connect } from "react-redux";

import { getPosts, getUsers, setPost, updatePost, storePost } from "../actions"
import { NotFound, Table, Form, Editor, Page, Show, Text } from "../components";

class Post extends Component{

    state = {        
        tab: 1
    }

    componentDidMount = () => {
        if (this.props.post.id == undefined) this.props.getPosts();
        if (this.props.author.id === undefined) this.props.getUsers();
    }
    
    render(){
        if (this.props.post === undefined) return <NotFound />        
        return(
            <Page                
                title={this.props.post.attributes.title}
                button={{
                    label: 'save',
                    onClick: () =>  this.props.post.id? this.props.updatePost(this.props.post):  this.props.storePost(this.props.post)
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
                    <Show label="نویسنده">{this.props.author.attributes.name}</Show>
                    <Show label="منتشر شده در">{this.props.post.attributes.published_at}</Show>
                    <Show label="چکیده" full>{this.props.post.attributes.abstract}</Show>
                    <Show label="بدنه" full>{this.props.post.attributes.body}</Show>
                </Form>
                <Form show={this.state.tab == 1}>
                    <Text
                        label='عنوان'
                        value={this.props.post.attributes.title}
                        disabled={this.props.post.id == undefined}
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

    let post = (props.match.params.post == 'create')? state.posts.create:
            (state.posts.index.length == 0)? state.posts.init:
            state.posts.index.find( element => element.id == props.match.params.post );

    let author = (state.users.index.length == 0 || post == undefined || post.id == undefined)? state.users.init:
            (props.match.params.post == 'create')? state.users.index.find( element => element.id == 1):
            state.users.index.find( element => element.id == post.attributes.user_id );
    return {
        post,
        author
    };
};

export default connect(mapStateToProps, { getPosts, getUsers, setPost, updatePost, storePost })(Post);