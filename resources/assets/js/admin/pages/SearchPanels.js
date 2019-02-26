import React, { Component } from "react";
import { connect } from "react-redux";

// import { getSerachPanels, getUsers } from "../actions"
import { getSearchPanels } from "../actions"
import { Page, Icon, Table } from "../components";

class SearchPanels extends Component{

    state = {}

    componentDidMount = () => {
        if(this.props.searchpanels.length == 0) this.props.getSearchPanels();
        // if(this.props.users.length == 0) this.props.getUsers();
    }

    render(){
        return(
            <div>sds</div>
        );
    }
}

const mapStateToProps = state => {
    return {
        searchpanels: state.searchpanels.index,
    };
};

export default connect(mapStateToProps, { getSearchPanels })(SearchPanels);