import React, { Component } from "react";
import MUIList from '@material-ui/core/List';
import ListItem from '@material-ui/core/ListItem';
import ListItemIcon from '@material-ui/core/ListItemIcon';
import ListItemText from '@material-ui/core/ListItemText';
import { Link } from "react-router-dom";

import { Icon } from "./";

export class List extends Component{

    item = (i, index) => {
        let icon = (i.icon !== undefined)? <ListItemIcon><Icon icon={i.icon} /></ListItemIcon> : null;        
        if (i.link == undefined) {
            return (
                <ListItem key={index} >
                    {icon}
                    <ListItemText primary={i.text} />
                </ListItem>
            );
        }else{
            return (
                <Link to={i.link} key={i.text} >
                    <ListItem button>
                        {icon}
                        <ListItemText primary={i.text} />
                    </ListItem>
                </Link>
            );
        }
    }

    render(){
        let items = this.props.items.map( (item, index) => this.item(item, index) );
        return(
            <MUIList component="nav">
                {items}
            </MUIList>
        );
    }
}