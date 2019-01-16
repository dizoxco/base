import React, {Component} from "react";

import { Radio, Select, Switch, Page, Table, Text, Checkbox } from "../components";
export default class Dashboard extends Component {
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
                <Table />
            </Page>
                
        );
    }
}