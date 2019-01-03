import React, {Component} from "react";
import Page from "../components/Page";

import { Radio, Select, Switch, Text, Checkbox } from "../components/form";

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
            </Page>
                
        );
    }
}