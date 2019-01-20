import React, { Component } from "react";
import TextField from '@material-ui/core/TextField';

export class Text extends Component{
    render(){
        let className = (this.props.half)? "w-1/2 p-2": "w-full p-2"
        return(
            <div className={className}>
                <TextField
                    id={ this.props.id }
                    label={ this.props.label }
                    value={ this.props.value }
                    placeholder={ this.props.placeholder }
                    variant="outlined"
                    onChange={this.props.onChange}
                    name={this.props.name}
                    type={this.props.type}
                    fullWidth
                />
            </div>
        );
    }
}