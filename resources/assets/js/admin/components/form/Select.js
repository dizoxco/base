import React, { Component } from "react";
import FormControl from '@material-ui/core/FormControl';
import InputLabel from '@material-ui/core/InputLabel';
import MenuItem from '@material-ui/core/MenuItem';
import OutlinedInput from '@material-ui/core/OutlinedInput';
import MUISelect from '@material-ui/core/Select';

export class Select extends Component{
    constructor(props) {
        super(props);
        this.state = {
            value: 10
        };
    }

    handleChange = event => {
        this.setState({ [event.target.name]: event.target.value });
    }

    render(){
        return(
            <FormControl variant="outlined">
                <InputLabel htmlFor="agee">Age</InputLabel>
                <MUISelect
                    value={this.state.value}
                    onChange={this.handleChange}
                    input={
                        <OutlinedInput
                            name="age"
                            labelWidth={50}
                            id="agee"
                        />
                    }
                >
                    <MenuItem value={10}>Ten</MenuItem>
                    <MenuItem value={20}>Twenty</MenuItem>
                </MUISelect>
            </FormControl>
        );
    }
}
