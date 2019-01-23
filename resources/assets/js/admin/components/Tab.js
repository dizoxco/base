import React, { Component } from "react";

import MUITab from '@material-ui/core/Tab';
import MUITabs from '@material-ui/core/Tabs';

export class Tab extends Component{

    state = {
        tab: this.props.tab ? this.props.tab : 0
    }

    handleChange = (event, tab) => {
        this.setState({tab});
        if (typeof this.props.onChange === "function") {
            this.props.onChange(tab);
        }
    }

    render(){        
        let tabs = this.props.tabs.map( (tab, index) => <MUITab key={index} label={tab} />);
        return(
                <MUITabs 
                    value={this.state.tab}
                    onChange={this.handleChange}
                >
                    {tabs}
                </MUITabs>
        );
    }
}