import React, {Component} from "react";
import {connect} from "react-redux";

import { getTags, updateTag } from "../actions"
import {Form, Loading, NotFound, Page, Show, Text} from "../components";

class Tag extends Component{

    state = {tab: 1};

    componentDidMount(){
        if (this.props.tag === null) {
            this.props.getTags();
        }
    }

    render()
    {
        if (this.props.tag === null) {
            return <Loading />;
        }

        if (this.props.tag === undefined) {
            return <NotFound />;
        }

        return(
            <Page                
                title={this.props.tag.attributes.label}
                button={{
                    label: 'ذخیره و به روزرسانی',
                    // onClick: () => this.props.updatetag(this.props.tag)
                }}
                tabs={['نمایش', 'ویرایش اطلاعات']}
                tab={this.state.tab}
                redirect={this.state.redirect}
                onChange={(tab) => this.setState({tab})}
            >
                <Form show={this.state.tab == 0}>
                    <Show label="برچسب">{this.props.tag.attributes.label}</Show>
                    <Show label="اسلاگ">{this.props.tag.attributes.slug}</Show>
                    <Show label="دیتا اضافه" full>{this.props.tag.attributes.metadata}</Show>
                </Form>
                <Form show={this.state.tab == 1}>
                    <Text
                        label='برچسب'
                        name='aaa'
                        value={this.props.tag.attributes.label}
                        onChange={ (e) => this.props.updateTag(this.props.tag.id, {title: e.target.value}) }
                    />
                    <Text
                        label='اسلاگ'
                        value={this.props.tag.attributes.slug}
                        onChange={ (e) => this.props.updateTag(this.props.tag.id, {title: e.target.value}) }
                    />
                    <Text
                        label='دیتا اضافه'
                        value={this.props.tag.attributes.metadata}
                        onChange={ (e) => this.props.updateTag(this.props.tag.id, {title: e.target.value}) }
                    />
                </Form>
            </Page>
        );
    }
}

const mapStateToProps = (state, props) => {
    // route id
    let id = props.match.params.tag;

    let tag = null;
    if (state.taxonomies.index.length) {
        // tag = state.taxonomies.tags.find(element => element.id == id);
    }

    return {tag};
};

export default connect(mapStateToProps, { getTags, updateTag })(Tag);