import React, { Component } from "react";

export class Show extends Component{
    render(){
        let cls = this.props.full? "mb-5 w-full": "mb-5 w-1/2";
        let content = this.props.full? <div>{this.props.children}</div>: this.props.children;
        if (this.props.label){
            return (
                <div className={cls}>
                    <strong>{this.props.label}:</strong> {content}
                </div>
            )
        }else{
            return <div className={cls}>{content}</div>
        }

    }
}