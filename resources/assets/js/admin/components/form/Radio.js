import React, { Component } from "react";

import MUIRadio from '@material-ui/core/Radio';
import FormControlLabel from '@material-ui/core/FormControlLabel';
import RadioGroup from '@material-ui/core/RadioGroup';

export default class Radio extends Component{
    render(){
        return(
            <RadioGroup
                aria-label="Gender"
                name="gender1"
                value="female"
            >
                <FormControlLabel
                    value="female"
                    control={<MUIRadio color="primary" />}
                    label="زن"
                    labelPlacement="start"
                />
                <FormControlLabel
                    value="male"
                    control={<MUIRadio color="primary" />}
                    label="مرد"
                    labelPlacement="start"
                />
            </RadioGroup>
        );
    }
}