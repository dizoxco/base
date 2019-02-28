import React, { Component } from "react";
import { connect } from "react-redux";

import { getSearchPanels, setSearchPanel, updateSearchPanel } from "../actions"
import { Loading, NotFound, Table, Form, Editor, Page, Show, Text, Select } from "../components";


class SearchPanel extends Component{
    state = {
        tab: 1
    }
    componentDidMount(){
        if (this.props.searchpanel === null) this.props.getSearchPanels();
    }

    render(){
        if (this.props.searchpanel === null) return <Loading />
        if (this.props.searchpanel === undefined) return <NotFound />
        return (
            <Page                
                title={this.props.searchpanel.attributes.title}
                button={{
                    label: 'save',
                    onClick: () => this.props.updateSearchPanel(this.props.searchpanel)
                }}
                tabs={['نمایش', 'ویرایش اطلاعات']}
                tab={this.state.tab}
                redirect={this.state.redirect}
                // loading={this.props.SearchPanel == null}
                onChange={(tab) => this.setState({tab})}
            >
                <Form show={this.state.tab == 0}>
                    <Show label="عنوان">{this.props.searchpanel.attributes.title}</Show>
                    <Show label="نامک">{this.props.searchpanel.attributes.slug}</Show>
                    <Show label="توضیحات" full>{this.props.searchpanel.attributes.description? this.props.searchpanel.attributes.description: '...'}</Show>
                </Form>
                <Form show={this.state.tab == 1}>
                    <Text
                        label='عنوان'
                        value={this.props.searchpanel.attributes.title}
                        half
                        onChange={ (e) => this.props.setSearchPanel(this.props.searchpanel.id, {title: e.target.value}) }
                    />
                    <Text
                        label='نامک'
                        value={this.props.searchpanel.attributes.slug}
                        half
                        onChange={ (e) => this.props.setSearchPanel(this.props.searchpanel.id, {slug: e.target.value}) }
                    />
                    <Text
                        label='توضیحات'
                        value={this.props.searchpanel.attributes.description}
                        half
                        onChange={ (e) => this.props.setSearchPanel(this.props.searchpanel.id, {description: e.target.value}) }
                    />
                </Form>
            </Page>
        )
    }
}

const mapStateToProps = (state, props) => {
    let searchpanel = (state.searchpanels.index.length)?
                state.searchpanels.index.find( element => element.id == props.match.params.searchpanel ):
                null;
    return {
        searchpanel
    }
};

export default connect(mapStateToProps, { getSearchPanels, setSearchPanel, updateSearchPanel })(SearchPanel);