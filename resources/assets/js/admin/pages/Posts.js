import React, { Component } from "react";
import { connect } from "react-redux";
import { increment } from "../actions"
class Posts extends Component{
    render(){
        return(
            <div onClick={this.props.increment}>Posts {this.props.counter}</div>
        );
    }
}

const mapStateToProps = state => {
    return {
        counter: state.posts.counter
    };
};

export default connect(mapStateToProps, { increment })(Posts);