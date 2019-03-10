import React, { Component } from "react";
import SortableJs from "sortablejs";

export class Sortable extends Component{

    state = {
        sorted: false
    }

    constructor(props) {
        super(props);
        this.myRef = React.createRef();
    }

    componentDidUpdate(){
        if (!this.state.sorted) {
            SortableJs.create(this.myRef.current,{
                animation: 200,
                onEnd: evt => {if (this.props.onChange != undefined) this.props.onChange(evt)}
            });
            this.setState({sorted: true});
        }
    }

    render(){        
        return(
            <div ref={this.myRef}>
                { this.props.children }
            </div>
        );
    }
}