import React, { Component } from "react";
import { connect } from "react-redux";

import { getPosts, setPost, updatePost, getUsers } from "../actions"
import { Changer, Form, Page, Show, Text } from "../components";

class User extends Component{

    state = {        
        tab: 0
    }

    componentDidMount(){
        if (this.props.user === null) {
            this.props.getUsers();
        }
    }


    render(){
        if (this.props.user === null) {
            return <div>loading ....................</div>
        }

        if (this.props.user === undefined) {
            return <div>undefined ....................</div>
        }
        
        return(
            <Page                
                // title={this.props.post.attributes.title}
                title={this.props.user.attributes.name}
                button={{
                    label: 'save',
                    onClick: updatePost(this.props.post)
                }}
                tabs={['نمایش', 'ویرایش اطلاعات']}
                tab={this.state.tab}
                redirect={this.state.redirect}
                onChange={(tab) => this.setState({tab})}
            >
                <Form show={this.state.tab == 0}>
                    <Show data={[
                        { label: 'عنوان',       value: this.props.user.attributes.name},
                        { label: 'نامک',        value: this.props.user.attributes.email},
                    ]} />
                </Form>
                <Form show={this.state.tab == 1}>
                    <Text
                        label='نام'
                        value={this.props.user.attributes.name}
                        half
                        onChange={ (e) => this.props.setPost(this.props.user.id, {title: e.target.value}) }
                    />
                    <Text
                        label='ایمیل'
                        value={this.props.user.attributes.email}
                        half
                        onChange={ (e) => this.props.setPost(this.props.user.id, {slug: e.target.value}) }
                    />
                    
                </Form>
            </Page>
        );
    }
}

const mapStateToProps = (state, props) => {
    if (state.users.index.length){
        var user = state.users.index.find( e => e.id == props.match.params.user );
    }else{
        var user = null;
    }

    return {
        user: user
    };
};

export default connect(mapStateToProps, { getPosts, setPost, updatePost, getUsers })(User);