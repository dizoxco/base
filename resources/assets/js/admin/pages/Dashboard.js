import React, { Component } from "react";
import { connect } from "react-redux";
import {getTaxonomies} from "../actions";
import { Radio, Select, Switch, Page, Table, Text, Checkbox } from "../components";
import AutoComplete from "../components/form/AutoComplete";

class Dashboard extends Component {


    componentDidMount() {
        if (this.props.taxonomies.length === 0 ){
            this.props.getTaxonomies();
        }
    }


    render() {
        let data =[];
        if(this.props.taxonomies.length > 0){
            const tags = this.props.taxonomies[1].relations.tags;
            data = tags.map(tag=> ({
                value:tag.id,
                label:tag.label
            }));
        }
        return (
            <Page
                title='داشبورد'
                button={{
                    label: 'save'
                }}
                tabs={['نمایش', 'ویرایش', 'پیرایش نیما']}
            >
                <AutoComplete
                    data={data}
                />

                <Radio />
                <Radio />
                <Checkbox />
                <Checkbox />
                <Switch />
                <Switch />
                <Select />
                <Select />
                <Text label="search" />


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