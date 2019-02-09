import React, {Component} from "react";
import {connect} from "react-redux";

import {getBusinesses, setBusiness, updateBusiness} from "../actions"
import {Form, Page, Show, Text} from "../components";

class Business extends Component {

    state = {
        tab: 0
    };

    componentDidMount() {
        if (this.props.business === null) {
            this.props.getBusinesses();

        }
    }


    render() {
        if (this.props.business === null) {
            return <div>loading ....................</div>
        }

        if (this.props.business === undefined) {
            return <div>undefined ....................</div>
        }

        return (
            <Page
                // title={this.props.business.attributes.title}
                title={this.props.business.attributes.title}
                button={{
                    label: 'save',
                    onClick: () => this.props.updateBusiness(this.props.business)
                }}
                tabs={['نمایش', 'ویرایش اطلاعات']}
                tab={this.state.tab}
                redirect={this.state.redirect}
                loading={this.props.business === undefined}
                onChange={(tab) => this.setState({tab})}
            >
                <Form show={this.state.tab === 0}>
                    <Show data={[
                        {label: 'عنوان', value: this.props.business.attributes.brand},
                    ]}/>
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

    return {
        business: (state.businesses.index.length) ?
            state.businesses.index.find(element => element.id === props.match.params.business) :
            null
    };
};

export default connect(mapStateToProps, {getBusinesses, setBusiness, updateBusiness})(Business);