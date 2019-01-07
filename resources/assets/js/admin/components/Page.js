import React, { Component } from "react";
import { Link } from "react-router-dom";

import { Button, Icon, Tab } from "./";

export default class Page extends Component{
    
    render(){
        let back, button, input;
        if( this.props.back.title !== undefined && this.props.back.link !== undefined ){
            back = <Link to={ this.props.back.link }><Icon icon="add" /></Link>;
        }
        
        if( this.props.button !== undefined ){
            let label = this.props.button.label ? this.props.button.label : null;
            button = <Button type="outlined" icon="delete" label={label} className="float-left" />;
        }


        return(
            <div id="page">
                <div id="page-header" className="bg-primary-light">
                    <div className="container mx-auto">
                        <h1 className="text-4xl leading-normal inline-block" >
                            { back }
                            { this.props.title }
                        </h1>                        
                        { button }
                        <Tab value={1} tabs={['الف', 'ب', 'جججج']} />
                    </div>
                </div>
                <div id="page-content" className=" bg-white rounded-t-lg">
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