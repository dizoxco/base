import React, {Component} from "react";
import {Redirect} from "react-router-dom";

import {Button, Tab} from "./";

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
        
        let button;

        let tabs = ( this.props.tabs !== undefined )? <Tab tabs={this.props.tabs} tab={this.props.tab} onChange={this.handleChange} />: null;
        
        if( this.props.button !== undefined ){
            let label = this.props.button.label ? this.props.button.label : null;
            let onClick = this.props.button.onClick ? this.props.button.onClick : undefined;
            let icon = this.props.button.icon ? this.props.button.onClick : null;
            button = <Button type="outlined" icon={icon} label={label} onClick={onClick} className="float-left" />;
        }


        return(
            <div id="page">
                <div id="page-header" className="bg-grey-darker pt-10 pb-20">
                    <div className="px-10 mx-auto flex items-center justify-between">
                        <h1 className="text-white text-xl my-6 leading-normal" >
                            { this.props.title }
                        </h1>
                        <div className="text-left header-icon">
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