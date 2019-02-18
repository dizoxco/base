import React, { Component } from "react";
import { connect } from "react-redux";
import {getTaxonomies} from "../actions";
import { Radio, Select, Switch, Page, Table, Text, Checkbox } from "../components";

class Dashboard extends Component {


    componentDidMount() {
        if (this.props.taxonomies.length === 0 ){
            this.props.getTaxonomies();
        }
    }


    render() {
        return (
            <Page                
                title='داشبورد'
                button={{
                    label: 'save'
                }}
                tabs={['نمایش', 'ویرایش', 'پیرایش نیما']}
            >
                <Text label="search" />
                <Radio />
                <Radio />
                <Checkbox />
                <Checkbox />
                <Switch />
                <Switch />
                <Select />
                <Select />
            </Page>
        );
    }
}
const mapStateToProps = state => {
    return {
        taxonomies: state.taxonomies.index,
    };
};

export default connect(mapStateToProps, { getTaxonomies })(Dashboard);