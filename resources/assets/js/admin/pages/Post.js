import React, { Component } from "react";
import { connect } from "react-redux";

import { getPosts, setPost, updatePost } from "../actions"
import { Changer, Form, Page, Show, Text } from "../components";

class Post extends Component{

    state = {        
        tab: 1
    }

    componentDidMount(){
        if (this.props.post === null) {
            this.props.getPosts();
        }
    }


    render(){
        if (this.props.post === null) {
            return <div>loading ....................</div>
        }

        if (this.props.post === undefined) {
            return <div>undefined ....................</div>
        }
        
        return(
            <Page                
                // title={this.props.post.attributes.title}
                title={this.props.post.attributes.title}
                button={{
                    label: 'save',
                    onClick: updatePost(this.props.post)
                }}
                tabs={['نمایش', 'ویرایش اطلاعات']}
                tab={this.state.tab}
                redirect={this.state.redirect}
                loading={this.props.post == undefined}
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
            </Page>
        );
    }
}

const mapStateToProps = (state, props) => {
    if (state.posts.posts.length){
        var post = state.posts.posts.find( element => element.id == props.match.params.user );
    }else{
        var post = null;
    }

    return {
        post: post
    };
};

export default connect(mapStateToProps, { getPosts, setPost, updatePost })(Post);