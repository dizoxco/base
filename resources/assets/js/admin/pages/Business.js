import React, {Component} from "react";
import {connect} from "react-redux";

import {
    copyBusiness,
    deleteBusiness,
    getBusinesses,
    getCities,
    getUsers,
    resetBusiness,
    restoreBusiness,
    setBusiness,
    setBusinessUsers,
    storeBusiness,
    updateBusiness
} from "../actions"
import {AutoComplete, Button, Form, Page, Show, Text} from "../components";

class Business extends Component {

    state = {activeTabIndex: (this.props.business.id == 0) ? 1 : 0};

    componentDidMount() {
        if (this.props.business != undefined) {
            if (this.props.business.id == undefined || this.props.business.attributes == undefined) {
                this.props.getBusinesses();
            }
        }

        if (this.props.cities.index == undefined)  {
            this.props.getCities();
        }

        if (this.props.users.index == undefined)  {
            this.props.getUsers();
        }
    }

    render() {
        return (
            <Page
                title={this.props.business.attributes.brand}
                buttons={<div>
                    <Button
                        type="icon"
                        icon="save"
                        visible={!this.props.trashed}
                        disabled={!this.props.edited}
                        onClick={() => this.props.business.id ? this.props.updateBusiness(this.props.business):  this.props.storeBusiness(this.props.business)}
                    />
                    <Button
                        type="icon"
                        icon="restore"
                        disabled={!(this.props.edited || this.props.trashed) }
                        onClick={() => this.props.trashed ?
                            this.props.restoreBusiness(this.props.business.id):
                            this.props.resetBusiness(this.props.business.id)
                        }
                    />
                    <Button
                        type="icon"
                        icon="delete"
                        visible={!this.props.trashed}
                        onClick={() => this.props.deleteBusiness(this.props.business.id, () => this.props.history.push('/admin/businesses'))}
                    />
                    <Button
                        type="icon"
                        icon="file_copy"
                        onClick={() => this.props.copyBusiness(this.props.business.id, () => this.props.history.push('/admin/businesses/create'))}
                        visible={this.props.business.id && !this.props.trashed}
                    />
                </div>}
                tabs={
                    this.props.business.id === 0 ? ['نمایش','افزودن کسب و کار'] : ['نمایش', 'ویرایش اطلاعات']
                }
                tab={this.state.activeTabIndex}
                redirect={this.state.redirect}
                onChange={(activeTabIndex) => this.setState({activeTabIndex})}
            >
                <Form show={this.state.activeTabIndex === 0}>
                    <Show label="عنوان">{this.props.business.attributes.brand}</Show>
                </Form>
                <Form show={this.state.activeTabIndex === 1}>
                    <Text
                        label='نام برند'
                        value={this.props.business.attributes.brand}
                        half
                        onChange={(e) => this.props.setBusiness(this.props.business.id, {brand: e.target.value})}
                    />
                    <Text
                        label='نامک'
                        value={this.props.business.attributes.slug}
                        half
                        onChange={(e) => this.props.setBusiness(this.props.business.id, {slug: e.target.value})}
                    />
                    <AutoComplete
                        data = {this.props.cities}
                        accessors= {{
                            value: 'id',
                            label: 'attributes.fullname'
                        }}
                        value = {this.props.business.attributes.city_id}
                        onChange = {(city_id) => this.props.setBusiness(this.props.business.id, {city_id: city_id})}
                    />
                    <AutoComplete
                        data = {this.props.users}
                        accessors= {{
                            value: 'id',
                            label: 'attributes.name'
                        }}
                        value = {this.props.business.relations.users}
                        onChange = {(users) => this.props.setBusinessUsers(this.props.business.id, users, this.props.users)}
                    />
                </Form>
            </Page>
        );
    }
}

const mapStateToProps = (state, props) => {
    let business;
    let cities = state.cities.index;
    let users = state.users.index;
    let id = props.match.params.business;

    if (id == 'create') {
        business = state.businesses.create;
    } else if (state.businesses.index.length == 0) {
        business = state.businesses.init;
    } else {
        business = state.businesses.index.find( element => element.id == id );
    }

    if (business == undefined) {
        business = state.businesses.trash.find( element => element.id == id );
    }


    let trashed = ( business != undefined && business.attributes.deleted_at != null);
    let edited = ( business != undefined && (business.oldAttributes != undefined || business.oldRelations != undefined));

    return {business, trashed, edited, cities, users};
};

export default connect(
    mapStateToProps,
    {copyBusiness, deleteBusiness, getBusinesses, getCities, getUsers, setBusiness, setBusinessUsers, restoreBusiness, resetBusiness, updateBusiness, storeBusiness}
    )(Business);