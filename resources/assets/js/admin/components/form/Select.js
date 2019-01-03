import React, { Component } from "react";
import FormControl from '@material-ui/core/FormControl';
import InputLabel from '@material-ui/core/InputLabel';
import MenuItem from '@material-ui/core/MenuItem';
import OutlinedInput from '@material-ui/core/OutlinedInput';
import MUISelect from '@material-ui/core/Select';

export default class Select extends Component{
    render(){
        return(
            <FormControl variant="outlined">
                <InputLabel htmlFor="agee">Age</InputLabel>
                <MUISelect
                    input={
                        <OutlinedInput
                            name="age"
                            labelWidth='ddd'
                            labelWidth="0"
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