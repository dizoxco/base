import React, { Component } from "react";

export class Form extends Component{
    render(){
        let className = (this.props.show == false)? 
            'flex flex-wrap -mx-2 page-tab':
            'flex flex-wrap -mx-2 page-tab show';
        return (
            <div className={className}>
                {this.props.children}
            </div>
        );
    }
}