import React, { Component } from "react";

import IconButton from '@material-ui/core/IconButton';
import MUIButton from '@material-ui/core/Button';

import { Icon } from "../";

export class Button extends Component{
    
    render(){
        let icon = this.props.icon ? <Icon icon={this.props.icon} /> : null;
        let type = (this.props.type == undefined) ? 'outlined' : this.props.type;
        if(this.props.visible == false) return null;
        switch (this.props.type) {
            case 'icon':
                return(
                    <IconButton 
                        className={this.props.className}
                        aria-label="Delete"
                        color="primary"
                        onClick={this.props.onClick}
                        disabled={this.props.disabled}
                    >
                        { icon }
                    </IconButton>
                );
            default:
                return(
                    <MUIButton
                        variant={type}
                        href={this.props.href}
                        color="primary"
                        className={this.props.className}
                        onClick={this.props.onClick}
                    >
                        { icon } { this.props.label }
                    </MUIButton>
                );
        }
        
    }
}