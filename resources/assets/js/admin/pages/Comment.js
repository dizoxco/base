import React, { Component } from "react";
import { connect } from "react-redux";

import { getComments, getPosts, setPost, updatePost } from "../actions"
import { Changer, Form, Page, Show, Text } from "../components";

class Comment extends Component{

    state = {        
        tab: 0
    }

    componentDidMount(){
        if (this.props.comment === null) {
            this.props.getComments();
        }
    }


    render(){
        if (this.props.comment === null) {
            return <div>loading ....................</div>
        }

        if (this.props.comment === undefined) {
            return <div>undefined ....................</div>
        }
        
        return(
            <Page                
                // title={this.props.post.attributes.title}
                title={'#'+this.props.comment.id}
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
                        { label: 'محتوا',       value: this.props.comment.attributes.body},
                    ]} />
                </Form>
                <Form show={this.state.tab == 1}>
                    
                </Form>
            </Page>
        );
    }
}

const mapStateToProps = (state, props) => {
    if (state.comments.index.length){
        var comment = state.comments.index.find( element => element.id == props.match.params.comment );
    }else{
        var comment = null;
    }

    return { comment };
};

export default connect(mapStateToProps, { getComments, getPosts, setPost, updatePost })(Comment);