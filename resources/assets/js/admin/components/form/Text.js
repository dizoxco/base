import React, { Component } from "react";
import TextField from '@material-ui/core/TextField';

export class Text extends Component{
    render(){
        return(
            <TextField
                id={ this.props.id }
                label={ this.props.label }
                defaultValue={ this.props.value }
                placeholder={ this.props.placeholder }
                variant="outlined"
                onChange={this.props.onChange}
                name={this.props.name}
                type={this.props.type}
            />
        );
    }
}