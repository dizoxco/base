import React, { Component } from "react";
import { connect } from "react-redux";

import { getBusinesses, getPosts, setPost, updatePost } from "../actions"
import { Changer, Form, Page, Show, Text } from "../components";

class Business extends Component{

    state = {        
        tab: 0
    }

    componentDidMount(){
        if (this.props.business === null) {
            this.props.getBusinesses();
        }
    }


    render(){
        if (this.props.business === null) {
            return <div>loading ....................</div>
        }

        if (this.props.business === undefined) {
            return <div>undefined ....................</div>
        }
        
        return(
            <Page                
                // title={this.props.business.attributes.title}
                title={this.props.business.attributes.title}
                button={{
                    label: 'save',
                    onClick: updatePost(this.props.business)
                }}
                tabs={['نمایش', 'ویرایش اطلاعات']}
                tab={this.state.tab}
                redirect={this.state.redirect}
                loading={this.props.business == undefined}
                onChange={(tab) => this.setState({tab})}
            >
                <Form show={this.state.tab == 0}>
                    <Show data={[
                        { label: 'عنوان',       value: this.props.business.attributes.brand},
                    ]} />
                </Form>
                <Form show={this.state.tab == 1}>
                   
                </Form>
            </Page>
        );
    }
}

const mapStateToProps = (state, props) => {
    var business = (state.businesses.index.length)?
        state.businesses.index.find( element => element.id == props.match.params.business ):
        null;
    return { business };
};

export default connect(mapStateToProps, { getBusinesses, getPosts, setPost, updatePost })(Business);