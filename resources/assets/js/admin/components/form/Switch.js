import React, { Component } from "react";
import MUISwitch from '@material-ui/core/Switch';

export default class Switch extends Component{
    render(){
        return(
            <MUISwitch
                value="checkedA"
            />
        );
    }
}