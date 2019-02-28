import React, { Component } from "react";
import { connect } from "react-redux";

import { getSearchPanels, setSearchPanel, storeSearchPanel, updateSearchPanel } from "../actions"
import { NotFound, Table, Form, Editor, Page, Show, Text, Select } from "../components";
// import { element } from "prop-types";


class SearchPanel extends Component{
    state = {
        tab: 1
    }
    // componentDidMount(){
    //     if (this.props.searchpanel === null) this.props.getSearchPanels();
    // }

    render(){
        // if (this.props.searchpanel === null) return <Loading />
        if (this.props.searchpanel === undefined) return <NotFound />
        if (this.props.searchpanel.id == undefined) this.props.getSearchPanels();
        return (
            <Page                
                title={this.props.searchpanel.attributes.title}
                button={{
                    label: 'save',
                    // onClick: () => this.props.updateSearchPanel(this.props.searchpanel)
                    onClick: () => this.props.searchpanel.id? this.props.updateSearchPanel(this.props.searchpanel): this.props.storeSearchPanel(this.props.searchpanel)
                }}
                tabs={['نمایش', 'ویرایش اطلاعات']}
                tab={this.state.tab}
                redirect={this.state.redirect}
                loading={this.props.searchpanel == null}
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
                        disabled={this.props.searchpanel.id == undefined}
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
    // let searchpanel = (state.searchpanels.index.length)?
    //             state.searchpanels.index.find( element => element.id == props.match.params.searchpanel ):
    //             null;
    let searchpanel = (props.match.params.searchpanel == 'create')? state.searchpanels.create:
                    (state.searchpanels.index.length == 0)? state.searchpanels.init:
                    state.searchpanels.index.find( element => element.id == props.match.params.searchpanel);
    return {
        searchpanel
    };
};

export default connect(mapStateToProps, { getSearchPanels, setSearchPanel, storeSearchPanel, updateSearchPanel })(SearchPanel);