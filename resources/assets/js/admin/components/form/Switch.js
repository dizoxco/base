import React, { Component } from "react";
import MUISwitch from '@material-ui/core/Switch';

export class Switch extends Component{
    render(){
        return(
            <MUISwitch
                value="checkedA"
            />
        );
    }
}