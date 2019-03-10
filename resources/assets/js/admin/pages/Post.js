import React, {Component} from "react";
import {connect} from "react-redux";

import {
    copyPost,
    deletePost,
    getPosts,
    getTags,
    getUsers,
    resetPost,
    restorePost,
    setPost,
    setPostTags,
    storePost,
    updatePost
} from "../actions"
import {AutoComplete, Button, Editor, Form, NotFound, Page, Show, Text} from "../components";

class Post extends Component{

    state = {        
        tab: (this.props.post.id == 0)? 1 : 0
    }

    componentDidMount = () => {
        if(this.props.post != undefined){
            if (this.props.post.id == undefined){
                this.props.getPosts();
            }
            if (this.props.author.id === undefined) this.props.getUsers();
            if (this.props.tags.length == 0) this.props.getTags();
        }
    }
    
    render(){
        if (this.props.post === undefined) return <NotFound />
        return(
            <Page                
                title={this.props.post.attributes.title}
                tabs={this.props.trashed? ['نمایش']: ['نمایش', 'ویرایش اطلاعات']}
                tab={this.state.tab}
                redirect={this.state.redirect}
                loading={this.props.post == null}
                onChange={(tab) => this.setState({tab})}
                buttons={<div>
                        <Button 
                            type="icon"
                            icon="save"
                            visible={!this.props.trashed}
                            disabled={!this.props.edited}
                            onClick={() => this.props.post.id? this.props.updatePost(this.props.post):  this.props.storePost(this.props.post)} 
                        />
                        <Button 
                            type="icon"
                            icon="restore"
                            disabled={!(this.props.edited || this.props.trashed) }
                            onClick={() => this.props.trashed? 
                                this.props.restorePost(this.props.post.id):
                                this.props.resetPost(this.props.post.id)
                            } 
                        />
                        <Button 
                            type="icon"
                            icon="delete"
                            visible={!this.props.trashed}
                            onClick={() => this.props.deletePost(this.props.post.id, () => this.props.history.push('/admin/posts'))} 
                        />
                        <Button 
                            type="icon"
                            icon="file_copy"
                            onClick={() => this.props.copyPost(this.props.post.id, () => this.props.history.push('/admin/posts/create'))} 
                            visible={this.props.post.id && !this.props.trashed}
                        />
                    </div>}
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
                    <AutoComplete 
                        data = {this.props.tags}
                        accessors= {{
                            value: 'id',
                            label: 'attributes.label'
                        }}
                        value = {this.props.post.relations.tags}
                        onChange = {(tags) => this.props.setPostTags(this.props.post.id, tags, this.props.tags)}
                    />
                    <AutoComplete 
                        data = {this.props.cats}
                        accessors= {{
                            value: 'id',
                            label: 'attributes.label'
                        }}
                        value = {this.props.post.relations.tags}
                        onChange = {(tags) => this.props.setPostTags(this.props.post.id, tags, this.props.cats)}
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

    let post;
    if (props.match.params.post == 'create') post = state.posts.create;
    else if(state.posts.index.length == 0) post = state.posts.init;
    else post = state.posts.index.find( element => element.id == props.match.params.post );
    if (post == undefined) post = state.posts.trash.find( element => element.id == props.match.params.post );
    
    let trashed = ( post != undefined && post.attributes.deleted_at != null);
    let edited = ( post != undefined && (post.oldAttributes != undefined || post.oldRelations != undefined));
  
    let author = (state.users.index.length == 0 || post == undefined || post.id == undefined)? state.users.init:
            (props.match.params.post == 'create')? state.users.index.find( element => element.id == 1):
            state.users.index.find( element => element.id == post.attributes.user_id );
    
    let tags = state.tags.index.length? state.tags.index.filter(tag => tag.attributes.taxonomy_id == 1): []
    let cats = state.tags.index.length? state.tags.index.filter(tag => tag.attributes.taxonomy_id == 2): []

    return {
        post,
        author,
        tags,
        trashed,
        edited,
        cats
    };
};

export default connect(mapStateToProps, { copyPost, deletePost, getTags, getPosts, getUsers, restorePost, resetPost, setPost, setPostTags, updatePost, storePost })(Post);
