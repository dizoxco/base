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
        counter: state.counter
    };
};

const mapDispatchToProps = dispatch => {
    return {
        // onIncrementCounter: () => dispatc({type: 'INCREMENT'})
        onIncrementCounter: increment
    };
};

export default connect(mapStateToProps, { increment })(Posts);