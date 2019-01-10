import React, { Component } from "react";
import ReactTable from "react-table";

export class Icon extends Component{
    render(){
        return(
            <span className="material-icons" id="page">{this.props.icon}</span>
        );
    }
}