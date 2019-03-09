import React, { Component } from "react";
import { connect } from "react-redux";

import { getSearchPanels, setSearchPanel, updateSearchPanel } from "../actions"
import { Button, Page, Icon, Table } from "../components";

class SearchPanels extends Component{

    state = {}

    componentDidMount = () => {
        if(this.props.searchpanels.length == 0) this.props.getSearchPanels();
    }

    render(){
        return(
            <Page
                title='پنل های جستجو'
                button={{
                    label: 'add new SearchPanel',
                    onClick: () => this.props.history.push('/admin/searchpanels/create')
                }}
                buttons = {<div>
                    <Button icon="add" type="icon" visible={!this.props.trash} onClick={() => this.props.history.push('/admin/searchpanels/create')} />
                    <Button icon="delete" type="icon" visible={!this.props.trash} onClick={() => this.props.history.push('/admin/searchpanels/trash')} />
                    <Button icon="list" type="icon" visible={this.props.trash} onClick={() => this.props.history.push('/admin/searchpanels')} />
                </div>}
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
                            Header: 'وضعیت',
                            width: 50,
                            Cell: row => row.original.oldAttributes? (<Icon icon="edit" />): '',
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

const mapStateToProps = (state, props) => {
    return {
        trash: props.location.pathname == '/admin/searchpanels/trash',
        searchpanels: (props.location.pathname == '/admin/searchpanels')? state.searchpanels.index: state.searchpanels.trash,
    };
};

export default connect(mapStateToProps, { getSearchPanels, setSearchPanel, updateSearchPanel })(SearchPanels);