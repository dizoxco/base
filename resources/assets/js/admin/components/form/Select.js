import React, { Component } from "react";
import FormControl from '@material-ui/core/FormControl';
import InputLabel from '@material-ui/core/InputLabel';
import MenuItem from '@material-ui/core/MenuItem';
import OutlinedInput from '@material-ui/core/OutlinedInput';
import MUISelect from '@material-ui/core/Select';

export class Select extends Component{
    // constructor(props) {
    //     // super(props);
    //     // this.state = {
    //     //     value: 10
    //     // };
    // }

    // handleChange = event => {
    //     this.setState({ [event.target.name]: event.target.value });
    // }

    handleChange = (event) => {
        if (typeof this.props.value == "object") {
                var result = this.props.data.find(d => this.deep_value(d, this.props.accessors.value) == event.target.value);
        }else{
                var result = event.target.value;
        }
        
        if (this.props.onChange != undefined) {
            this.props.onChange(result);
        }
    };

    deep_value = (obj, path) => {
        return path
            .replace(/\[|\]\.?/g, '.')
            .split('.')
            .filter(s => s)
            .reduce((acc, val) => acc && acc[val], obj);
    }

    render(){
        var options = this.props.data.map(opt => {
                if (typeof opt == 'object') {
                    return <MenuItem value={this.deep_value(opt, this.props.accessors.value)}>
                        {this.deep_value(opt, this.props.accessors.label)}
                    </MenuItem>
                }else{
                    return <MenuItem value={opt}>
                        {opt}
                    </MenuItem>
                }
            })
        
        var value = this.props.value;
        if (typeof value == "object") {
            value = this.props.data.find(d => 
                    this.deep_value(d, this.props.accessors.value) == this.deep_value(this.props.value, this.props.accessors.value)
                );
            value = this.deep_value(value, this.props.accessors.value);
        }

        let className = (this.props.half)? "w-1/2 p-2": this.props.quarter?  "w-1/4 p-2": "w-full p-2";
        return(
            <div className={className}>
                <FormControl variant="outlined">
                    <InputLabel htmlFor="agee">{this.props.label}</InputLabel>
                    <MUISelect
                        value={this.props.value}
                        onChange={this.handleChange}
                        input={
                            <OutlinedInput
                                name={this.props.name}
                                labelWidth={50}
                                id="agee"
                            />
                        }
                    >
                        {options}
                    </MUISelect>
                </FormControl>
            </div>
        );
    }
}
