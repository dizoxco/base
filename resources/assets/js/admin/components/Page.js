import React, { Component } from "react";
import { Link } from "react-router-dom";

import { Button, Icon, Tab } from "./";

export class Page extends Component{
    
    render(){
        let back, button;

        let tabs = ( this.props.tabs !== undefined )? <Tab tabs={this.props.tabs} />: null;
        
        if( this.props.button !== undefined ){
            let label = this.props.button.label ? this.props.button.label : null;
            button = <Button type="outlined" icon="delete" label={label} className="float-left" />;
        }


        return(
            <div id="page">
                <div id="page-header" className="bg-primary-light">
                    <div className="container mx-auto">
                        <h1 className="text-4xl leading-normal inline-block" >
                            { this.props.title }
                        </h1>                        
                        { button }
                    </div>
                </div>
                <div id="page-content" className="bg-white rounded-t-lg overflow-hidden">
                    {tabs}
                    <div className="container mx-auto" >
                        { this.props.children }
                    </div>
                    <br/>
                    <br/>
                    <br/>
                    <br/>
                </div>
            </div>
        );
    }
}