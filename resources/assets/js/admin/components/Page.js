import React, { Component } from "react";
import { Link } from "react-router-dom";

import { Button, Text } from "./form";

export default class Page extends Component{
    
    render(){
        let back, button, input;
        if( this.props.back.title !== undefined && this.props.back.link !== undefined ){
            back = <div><Link to={ this.props.back.link }>{ this.props.back.title }</Link></div>;
        }
        
        if( this.props.button !== undefined ){
            let label = this.props.button.label ? this.props.button.label : null;
            button = <Button label={label} />;
        }

        if( this.props.input !== undefined ){

            input = <Text label="search" />;
        }

        return(
            <div id="page">
                <div id="page-header" className="bg-primary-light">
                    { back }
                    { this.props.title }
                    { this.props.description }
                    { input }
                    { button }
                </div>
                <div id="page-content" className="container mx-auto shadow-md bg-blue rounded-lg">
                    { this.props.children }
                    <br/>
                    <br/>
                    <br/>
                    <br/>
                </div>
            </div>
        );
    }
}