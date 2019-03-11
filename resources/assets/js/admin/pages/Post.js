import React, {Component} from "react";
import {connect} from "react-redux";

import { reduxCopier, reduxDeleter, reduxGetter, reduxReseter, reduxRestorer, reduxSeter, reduxStorer } from "../../helpers";
import {AutoComplete, Button, Editor, Form, NotFound, Page, Show, Text} from "../components";

class Post extends Component{

    state = {        
        tab: (this.props.post.id == 0)? 1 : 0
    }

    componentDidMount = () => {
        if(this.props.post != undefined){
            if (this.props.post.id == undefined) this.props.reduxGetter('post')
            if (this.props.author.id === undefined) this.props.reduxGetter('user')
            if (this.props.tags.length == 0) this.props.reduxGetter('tag')
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
                            onClick={() => this.props.reduxStorer(this.props.post)} 
                        />
                        <Button 
                            type="icon"
                            icon="restore"
                            disabled={!(this.props.edited || this.props.trashed) }
                            onClick={() => this.props.trashed? 
                                this.props.reduxRestorer(this.props.post):
                                this.props.reduxReseter(this.props.post)
                            } 
                        />
                        <Button 
                            type="icon"
                            icon="delete"
                            visible={!this.props.trashed}
                            onClick={() => this.props.reduxDeleter(this.props.post, () => this.props.history.push('/admin/posts'))} 
                        />
                        <Button 
                            type="icon"
                            icon="file_copy"
                            onClick={() => this.props.reduxCopier(this.props.post, () => this.props.history.push('/admin/posts/create'))} 
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
                        // onChange={ (e) => this.props.setPost(this.props.post.id, 'attributes.title', e.target.value) }
                        onChange={ (e) => this.props.reduxSeter(this.props.post, 'attributes.title', e.target.value) }
                    />
                    <Text
                        label='نامک'
                        value={this.props.post.attributes.slug}
                        half
                        onChange={ (e) => this.props.reduxSeter(this.props.post, 'attributes.slug', e.target.value) }
                    />
                    <Text
                        label='چکیده'
                        name='aaa'
                        value={this.props.post.attributes.abstract}
                        onChange={ (e) => this.props.reduxSeter(this.props.post, 'attributes.abstract', e.target.value) }
                    />
                    <AutoComplete 
                        data = {this.props.tags}
                        accessors= {{
                            value: 'id',
                            label: 'attributes.fullname'
                        }}
                        value = {this.props.post.relations.tags}
                        onChange = {(tags) => this.props.reduxSeter(this.props.post, 'relations.tags', tags)}
                    />
                    <Text
                        label='محتوا'
                        value={this.props.post.attributes.body}
                        onChange={ (e) => this.props.reduxSeter(this.props.post, 'attributes.body', e.target.value) }
                    />
                    <Editor />
                </Form>
            </Page>
        );
    }
}

const mapStateToProps = (state, props) => {

    let post;
    if (props.match.params.post == 'create') post = state.post.create;
    else if(state.post.index.length == 0) post = state.post.init;
    else post = state.post.index.find( element => element.id == props.match.params.post );
    if (post == undefined) post = state.post.trash.find( element => element.id == props.match.params.post );
    
    let trashed = ( post != undefined && post.attributes.deleted_at != null);
    let edited = ( post != undefined && (post.oldAttributes != undefined || post.oldRelations != undefined));
  
    let author = (state.user.index.length == 0 || post == undefined || post.id == undefined)? state.user.init:
            (props.match.params.post == 'create')? state.user.index.find( element => element.id == 1):
            state.user.index.find( element => element.id == post.attributes.user_id );
    
    let tags = state.tag.index.length? state.tag.index.filter(tag => tag.attributes.taxonomy_group_name == 'post'): []

    return {
        post,
        author,
        tags,
        trashed,
        edited,
    };
};

export default connect(mapStateToProps, { reduxCopier, reduxDeleter, reduxGetter, reduxReseter, reduxRestorer, reduxSeter, reduxStorer})(Post);
