import React, {Component} from "react";
import Page from "../components/Page";

import { Radio, Select, Switch, Table, Text, Checkbox } from "../components";

export default class Dashboard extends Component {
    render() {
        return (
            <Page
                back={{
                    title: 'omid',
                    link: 'home'
                }}
                title='داشبورد'
                description='توضیحات'
                input={{
                    placeholder: 'جستجو'
                }}
                button={{
                    label: 'save'
                }}
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