import {connect} from "react-redux";
import React, {Component} from "react";
import {Button, Form, NotFound, Page, Table, Text} from "../components";
import {getTags, getTaxonomies, setTaxonomy, storeTaxonomy, updateTaxonomy} from "../actions"

class Taxonomy extends Component {

    state = {activeTabIndex: 0};

    componentDidMount = () => {
        if (this.props.taxonomy.id === undefined) {
            this.props.getTaxonomies();
        }

        if (this.props.tags.length === 0) {
            this.props.getTags();
        }
    };

    storeTaxonomy = () => {
        return () => this.props.storeTaxonomy(
            this.props.taxonomy,
            () => this.props.history.push('/admin/taxonomies')
        );
    };

    updateTaxonomy = () => {
        return () => this.props.updateTaxonomy(
            this.props.taxonomy,
            () => this.props.history.push('/admin/taxonomies')
        );
    };

    render() {
        if (this.props.taxonomy == undefined) {
            return <NotFound/>
        }

        if (this.props.match.params.taxonomy === 'create') {
            return (
                <Page
                    title="گروه تگ جدید"
                    button={{label: 'ذخیره', onClick: this.storeTaxonomy()}}
                >
                    <Form>
                        <Text
                            label='نام گروه'
                            value={this.props.taxonomy.attributes.group_name}
                            half
                            onChange={(e) => this.props.setTaxonomy(this.props.taxonomy.id, {group_name: e.target.value})}
                        />
                        <Text
                            label='اسلاگ'
                            value={this.props.taxonomy.attributes.slug}
                            half
                            onChange={(e) => this.props.setTaxonomy(this.props.taxonomy.id, {slug: e.target.value})}
                        />
                        <Text
                            label='برچسب'
                            value={this.props.taxonomy.attributes.label}
                            half
                            onChange={(e) => this.props.setTaxonomy(this.props.taxonomy.id, {label: e.target.value})}
                        />
                    </Form>
                </Page>
            );
        }

        return (
            <Page
                title={this.props.taxonomy.attributes.label}
                button={{
                    label: 'تگ جدید',
                    onClick: () => this.props.history.push(
                        '/admin/taxonomies/' + this.props.taxonomy.id + '/tags/create'
                    )
                }}
                tabs={['نمایش', 'ویرایش اطلاعات']}
                tab={this.state.activeTabIndex}
                onChange={(activeTabIndex) => this.setState({activeTabIndex})}
            >
                <Form show={this.state.activeTabIndex == 0}>
                    <Table
                        data={this.props.tags}
                        tdClick={(row) => this.props.history.push(
                            '/admin/taxonomies/' + this.props.match.params.taxonomy + '/tags/' + row.original.id
                        )}
                        columns={[
                            {
                                Header: 'شناسه',
                                accessor: 'id',
                                width: 100
                            },
                            {
                                Header: 'والد',
                                accessor: 'attributes.parent_id',
                                width: 100
                            },
                            {
                                Header: 'برچسب',
                                accessor: 'attributes.label',
                                width: 400
                            },
                            {
                                Header: 'اسلاگ',
                                width: 200,
                                accessor: 'attributes.slug',
                            },
                            {
                                Header: 'دیتا اضافه',
                                width: 100,
                                accessor: 'attributes.metadata',
                            }
                        ]}
                    />
                </Form>
                <Form show={this.state.activeTabIndex == 1}>
                    <Text
                        label='نام گروه'
                        value={this.props.taxonomy.attributes.group_name}
                        half
                        onChange={(e) => this.props.setTaxonomy(this.props.taxonomy.id, {group_name: e.target.value})}
                    />
                    <Text
                        label='اسلاگ'
                        value={this.props.taxonomy.attributes.slug}
                        half
                        onChange={(e) => this.props.setTaxonomy(this.props.taxonomy.id, {slug: e.target.value})}
                    />
                    <Text
                        label='برچسب'
                        value={this.props.taxonomy.attributes.label}
                        half
                        onChange={(e) => this.props.setTaxonomy(this.props.taxonomy.id, {label: e.target.value})}
                    />
                    <Button
                        type="outlined"
                        icon="save"
                        label="به روز رسانی"
                        onClick={this.updateTaxonomy()}
                        className="float-left"/>
                </Form>
            </Page>
        );
    }
}

const mapStateToProps = (state, props) => {
    // route id
    let id = props.match.params.taxonomy;
    let taxonomy = null;
    let tags = state.tags.index.filter(element => element.attributes.taxonomy_id == id);


    if (id === 'create') {
        taxonomy = state.taxonomies.create;
    } else {
        if (state.taxonomies.index.length == 0) {
            taxonomy = state.taxonomies.init;
        } else {
            taxonomy = state.taxonomies.index.find(element => element.id == id);
        }
    }

    return {taxonomy, tags};
};

export default connect(
    mapStateToProps,
    {getTaxonomies, getTags, setTaxonomy, storeTaxonomy, updateTaxonomy}
    )(Taxonomy);