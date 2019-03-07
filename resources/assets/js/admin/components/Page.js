import React, { Component } from "react";
import { Redirect } from "react-router-dom";

import { Button, Icon, Tab } from "./";

export class Page extends Component{
    
    handleChange = (tab) => {
        if (typeof this.props.onChange === "function") {
            this.props.onChange(tab);
        }
    }

    render(){
        if (this.props.loading){
            return <div>Loading ...</div>
        }

        if (this.props.redirect !== undefined) {
            return <Redirect push to={this.props.redirect} />;
        }
        
        let back, button;

        let tabs = ( this.props.tabs !== undefined )? <Tab tabs={this.props.tabs} tab={this.props.tab} onChange={this.handleChange} />: null;
        
        if( this.props.button !== undefined ){
            let label = this.props.button.label ? this.props.button.label : null;
            let onClick = this.props.button.onClick ? this.props.button.onClick : undefined;
            button = <Button type="outlined" icon="delete" label={label} onClick={onClick} className="float-left" />;
        }


        return(
            <div id="page">
                <div id="page-header" className="bg-primary-light">
                    <div className="container mx-auto flex">
                        <h1 className="text-4xl leading-normal inline-block w-2/3" >
                            { this.props.title }
                        </h1>
                        <div className="w-1/3 text-left">
                            {this.props.buttons}
                        </div>
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