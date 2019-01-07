import React, { Component } from "react";

import AppBar from '@material-ui/core/AppBar';
import MUITab from '@material-ui/core/Tab';
import MUITabs from '@material-ui/core/Tabs';

export default class Tab extends Component{

    state = {
        value: this.props.value ? this.props.value : 0
    }

    render(){
        let tabs = this.props.tabs.map( tab => <MUITab label={tab} />);
        return(
            <AppBar position="static">
                <MUITabs value={this.state.value} onChange={ (event, value) => this.setState({value}) }>
                    {tabs}
                </MUITabs>
            </AppBar>
        );
    }
}