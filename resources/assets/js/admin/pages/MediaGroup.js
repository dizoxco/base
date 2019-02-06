import React, { Component } from "react";
import { connect } from "react-redux";

import { getMediaGroup, getMediaGroups, getPosts, getUsers } from "../actions"
import { Page, Icon, Table } from "../components";

class MediaGroup extends Component{

    state = {}

    componentDidMount = () => {
        // this.props.getMediaGroup(1);
        if(this.props.mediagroup == null) this.props.getMediaGroups();
        // console.log(this.props);
         
    }

    render(){
        if(this.props.media.length == 0) this.props.getMediaGroup(1);
        
        var media = this.props.media.map((medium)=>{
            console.log(medium);
                        
            return <div className="w-1/12 p-1" key={medium.id}><img src={medium.attributes.conversions.thumb.url} /></div>;
        });

        return(
            <Page                
                title='رسانه'
                button={{
                    label: 'save'
                }}
                onChange={(value) => this.setState({tab: value})}
            >
                <div className="flex flex-wrap">
                    {media}
                </div>
            </Page>
        );
    }
}

const mapStateToProps = (state, props) => {
    var mediagroup = (state.media.mediagroups.length)? state.media.mediagroups.find( element => element.id == props.match.params.mediagroup ): null;    
    return {
        mediagroup,
        media: (mediagroup == null || mediagroup.media === undefined)? []: mediagroup.media
    };
};

export default connect(mapStateToProps, { getMediaGroup, getMediaGroups, getPosts, getUsers })(MediaGroup);