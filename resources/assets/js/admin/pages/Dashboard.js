import React, {Component} from "react";
import Page from "../components/Page";

import { Radio, Text, Checkbox } from "../components/form";

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
                <Checkbox />
                <Checkbox />
            </Page>
                
        );
    }
}