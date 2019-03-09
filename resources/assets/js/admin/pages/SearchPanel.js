import React, { Component } from "react";
import { connect } from "react-redux";

import { copySearchPanel, deleteSearchPanel, getSearchPanels, restoreSearchPanel, resetSearchPanel, setSearchPanel, storeSearchPanel, updateSearchPanel } from "../actions"
import { Button, NotFound, Form, Page, Select, Show, Text } from "../components";
// import { element } from "prop-types";


class SearchPanel extends Component{
    state = {
        tab: 1
    }
    componentDidMount(){
        if (this.props.searchpanel === undefined) return <NotFound />
        if (this.props.searchpanel.id == undefined) this.props.getSearchPanels();
    }

    render(){
        let ordersold = this.props.searchpanel.attributes.options.order.order.map((o, i) => <div className="w-full flex">
                <Text
                    label='عنوان'
                    value={o.label}
                    disabled={this.props.searchpanel.id == undefined}
                    half
                    onChange={ (e) => this.props.setSearchPanel(this.props.searchpanel.id, {title: e.target.value}) }
                />
                <Select
                    label='مدل'
                    quarter
                    value={this.props.searchpanel.attributes.model? this.props.searchpanel.attributes.model: 'App\\Models\\Product'}
                    data={[{label: 'محصولات', value: 'App\\Models\\Product'}, {label: 'کسب و کارها', value: 'App\\Models\\Bussiness'}]}
                    accessors={{
                        value: 'value',
                        label: 'label'
                    }}
                    onChange={ (value) => this.props.setSearchPanel(this.props.searchpanel.id, {model: value}) }
                />
                <Select
                    label='مدل'
                    quarter
                    value={this.props.searchpanel.attributes.model? this.props.searchpanel.attributes.model: 'App\\Models\\Product'}
                    data={[{label: 'محصولات', value: 'App\\Models\\Product'}, {label: 'کسب و کارها', value: 'App\\Models\\Bussiness'}]}
                    accessors={{
                        value: 'value',
                        label: 'label'
                    }}
                    onChange={ (value) => this.props.setSearchPanel(this.props.searchpanel.id, {model: value}) }
                />
            </div>)
        let orders = this.props.searchpanel.attributes.options.order.order.map((o, i) => <div className="w-full flex">
                <Text
                    label='عنوان'
                    value={o.label}
                    disabled={this.props.searchpanel.id == undefined}
                    half
                    onChange={ (e) => this.props.setSearchPanel(this.props.searchpanel.id, {title: e.target.value}) }
                />
                <Select
                    label='مدل'
                    quarter
                    value={this.props.searchpanel.attributes.model? this.props.searchpanel.attributes.model: 'App\\Models\\Product'}
                    data={[{label: 'محصولات', value: 'App\\Models\\Product'}, {label: 'کسب و کارها', value: 'App\\Models\\Bussiness'}]}
                    accessors={{
                        value: 'value',
                        label: 'label'
                    }}
                    onChange={ (value) => this.props.setSearchPanel(this.props.searchpanel.id, {model: value}) }
                />
                <Select
                    label='مدل'
                    quarter
                    value={this.props.searchpanel.attributes.model? this.props.searchpanel.attributes.model: 'App\\Models\\Product'}
                    data={[{label: 'محصولات', value: 'App\\Models\\Product'}, {label: 'کسب و کارها', value: 'App\\Models\\Bussiness'}]}
                    accessors={{
                        value: 'value',
                        label: 'label'
                    }}
                    onChange={ (value) => this.props.setSearchPanel(this.props.searchpanel.id, {model: value}) }
                />
            </div>)
        return (
            <Page                
                title={this.props.searchpanel.attributes.title}
                buttons={<div>
                    <Button 
                        type="icon"
                        icon="save"
                        visible={!this.props.trashed}
                        disabled={!this.props.edited}
                        onClick={() => this.props.searchpanel.id? this.props.updateSearchPanel(this.props.searchpanel):  this.props.storeSearchPanel(this.props.searchpanel)} 
                    />
                    <Button 
                        type="icon"
                        icon="restore"
                        disabled={!(this.props.edited || this.props.trashed) }
                        onClick={() => this.props.trashed? 
                            this.props.restoreSearchPanel(this.props.searchpanel.id):
                            this.props.resetSearchPanel(this.props.searchpanel.id)
                        } 
                    />
                    <Button 
                        type="icon"
                        icon="delete"
                        visible={!this.props.trashed}
                        onClick={() => this.props.deleteSearchPanel(this.props.searchpanel.id, () => this.props.history.push('/admin/searchpanels'))} 
                    />
                    <Button 
                        type="icon"
                        icon="file_copy"
                        onClick={() => this.props.copySearchPanel(this.props.searchpanel.id, () => this.props.history.push('/admin/searchpanels/create'))} 
                        visible={this.props.searchpanel.id && !this.props.trashed}
                    />
                </div>}
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
                    <Select
                        label='مدل'
                        half
                        value={this.props.searchpanel.attributes.model? this.props.searchpanel.attributes.model: 'App\\Models\\Product'}
                        data={[{label: 'محصولات', value: 'App\\Models\\Product'}, {label: 'کسب و کارها', value: 'App\\Models\\Bussiness'}]}
                        accessors={{
                            value: 'value',
                            label: 'label'
                        }}
                        onChange={ (value) => this.props.setSearchPanel(this.props.searchpanel.id, {model: value}) }
                    />
                    مرتب سازی
                    {orders}
                </Form>
            </Page>
        )
    }
}

const mapStateToProps = (state, props) => {
    // let searchpanel = (state.searchpanels.index.length)?
    //             state.searchpanels.index.find( element => element.id == props.match.params.searchpanel ):
    //             null;
    let searchpanel;
    if (props.match.params.searchpanel == 'create') searchpanel = state.searchpanels.create;
    else if (state.searchpanels.index.length == 0) searchpanel = state.searchpanels.init;
    else searchpanel = state.searchpanels.index.find( element => element.id == props.match.params.searchpanel);
    if(searchpanel == undefined) searchpanel = state.searchpanels.trash.find( element => element.id == props.match.params.searchpanel);
    
    let trashed = ( searchpanel != undefined && searchpanel.attributes.deleted_at != null);
    let edited = ( searchpanel != undefined && searchpanel.oldAttributes != undefined);

    return {
        searchpanel,
        edited,
        trashed
    };
};

export default connect(mapStateToProps, { copySearchPanel, deleteSearchPanel, getSearchPanels, restoreSearchPanel, resetSearchPanel, setSearchPanel, storeSearchPanel, updateSearchPanel })(SearchPanel);