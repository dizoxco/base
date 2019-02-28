import React, { Component } from "react";
import { connect } from "react-redux";

import { getSearchPanels, setSearchPanel, updateSearchPanel } from "../actions"
import { Page, Table } from "../components";

class SearchPanels extends Component{

    state = {}

    componentDidMount = () => {
        if(this.props.searchpanels.length == 0) this.props.getSearchPanels();
    }

    render(){
        return(
            <Page
                title=''
                button={{
                    label: 'save'
                }}
                onChange={(value) => this.setState({tab: value})}
            >
                <Table
                    data={this.props.searchpanels}
                    tdClick={(r) => this.props.history.push('/admin/searchpanels/' + r.original.id)}
                    columns={[
                        {
                            Header: '#',
                            accessor: 'id',
                            width: 70
                        },
                        {
                            Header: 'عنوان',
                            accessor: 'attributes.title',
                        },
                        {
                            Header: 'slug',
                            accessor: 'attributes.slug',
                        },
                    ]}
                />
            </Page>
        );
    }
}

const mapStateToProps = state => {
    return {
        searchpanels: state.searchpanels.index,
    };
};

export default connect(mapStateToProps, { getSearchPanels, setSearchPanel, updateSearchPanel })(SearchPanels);