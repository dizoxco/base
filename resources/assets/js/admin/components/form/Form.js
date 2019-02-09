import React, { Component } from "react";

export class Form extends Component{
    render(){
        let className = (this.props.show == false)? 
            'flex flex-wrap p-4 page-tab':
            'flex flex-wrap p-4 page-tab show';
        return (
            <div className={className}>
                {this.props.children}
            </div>
        );
    }
}