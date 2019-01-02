import React, { Component } from "react";

import MUICheckbox from '@material-ui/core/Checkbox';
import FormControlLabel from '@material-ui/core/FormControlLabel';

export default class Checkbox extends Component{
    render(){
        return(
            <FormControlLabel
                control={
                    <MUICheckbox
                        checked={true}
                        value="checkedA"
                    />
                }
                label="Secondary"
            />
        );
    }
}