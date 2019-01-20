import React, { Component } from "react";

export class PageTab extends Component{
    render(){
        let className = (this.props.show)? 'page-tab show': 'page-tab';
        return (
            <div className={className}>
                {this.props.children}
            </div>
        );
    }
}