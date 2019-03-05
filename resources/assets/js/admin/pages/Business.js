import React, {Component} from "react";
import {connect} from "react-redux";

import {getBusinesses, setBusiness, updateBusiness, storeBusiness} from "../actions"
import {Form, Page, Show, Text, NotFound} from "../components";

class Business extends Component {

    state = { 
        tab: 1
    };

    componentDidMount() {
            if (this.props.business === undefined) return <NotFound />
            if (this.props.business.id == undefined) this.props.getBusinesses();  
    }

    render() {
        return (
            <Page
                title={this.props.business.attributes.brand}
                button={{
                    label: 'save',
                    onClick: () => this.props.business.id? this.props.updateBusiness(this.props.business): this.props.storeBusiness(this.props.business)
                }}
                // tabs={this.props.business.id === 0 ? ['نمایش', 'افزودن کسب و کار'] :['نمایش', 'ویرایش اطلاعات']}
                tabs={['نمایش', 'ویرایش اطلاعات']}
                tab={this.state.tab}
                redirect={this.state.redirect}
                onChange={(tab) => this.setState({tab})}
            >
                <Form show={this.state.tab === 0}>
                    <Show label="عنوان">{this.props.business.attributes.brand}</Show>
                </Form>
                <Form show={this.state.tab === 1}>
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
                </Form>
            </Page>
        );
    }
}

const mapStateToProps = (state, props) => {
    let business = (props.match.params.business == 'create')? state.businesses.create:
            (state.businesses.index.length == 0)? state.businesses.init:
            state.businesses.index.find( element => element.id == props.match.params.business);
    return {
        business
    };
};

export default connect(mapStateToProps, {getBusinesses, setBusiness, updateBusiness , storeBusiness})(Business);