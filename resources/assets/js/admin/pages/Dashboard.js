import React, { Component } from "react";
import { connect } from "react-redux";
import {getTaxonomies} from "../actions";
import { AutoComplete, Radio, Select, Switch, Page, Table, Text, Checkbox } from "../components";

class Dashboard extends Component {


    componentDidMount() {
        if (this.props.taxonomies.length === 0 ){
            this.props.getTaxonomies();
        }
    }

    
    render() {
        let data =[];
        
        if(this.props.taxonomies.length > 0){
            data = this.props.taxonomies.map( tax => ({value: tax.id, label: tax.attributes.label }))
            // const tags = this.props.taxonomies[1].relations.tags;
            // data = tags.map(tag=> ({
            //     value:tag.id,
            //     label:tag.label
            // }));
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
                    data={this.props.taxonomies}
                    accessors={{label: 'attributes.label', value: 'id'}}
                    value={[this.props.taxonomies[0]]}
                    // selectValue
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
        taxonomies: state.taxonomy.index,
    };
};

export default connect(mapStateToProps, { getTaxonomies })(Dashboard);