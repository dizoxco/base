import React, { Component } from "react";
import ExpansionPanel from '@material-ui/core/ExpansionPanel';
import ExpansionPanelSummary from '@material-ui/core/ExpansionPanelSummary';
import ExpansionPanelDetails from '@material-ui/core/ExpansionPanelDetails';
// import ExpandMoreIcon from '@material-ui/icons/ExpandMore';

export class Expand extends Component{
    render(){        
        
        return(
            <ExpansionPanel>
                <ExpansionPanelSummary expandIcon={<span>d</span>}>
                    <div >{this.props.title}</div>
                </ExpansionPanelSummary>
                <ExpansionPanelDetails>
                    { this.props.children }
                </ExpansionPanelDetails>
            </ExpansionPanel>
        );
    }
}