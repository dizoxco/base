import React, { Component } from "react";

import MUITab from '@material-ui/core/Tab';
import MUITabs from '@material-ui/core/Tabs';

export class Tab extends Component{

    state = {
        value: this.props.value ? this.props.value : 0
    }

    render(){        
        let tabs = this.props.tabs.map( (tab, index) => <MUITab key={index} label={tab} />);
        return(
                <MUITabs 
                    value={this.state.value}
                    onChange={ (event, value) => this.setState({value}) }
                >
                    {tabs}
                </MUITabs>
        );
    }
}