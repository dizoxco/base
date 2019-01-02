import React, { Component } from "react";
import MUIButton from '@material-ui/core/Button';

export default class Button extends Component{
    
    render(){
        return(
            <MUIButton 
                variant="contained" 
                href={this.props.href}
                color="primary"
            >
                { this.props.label }
            </MUIButton>
        );
    }
}