import React, {Component} from "react";
import {connect} from "react-redux";

import {getTaxonomies} from "../actions"
import {Page, Table} from "../components";

class Taxonomy extends Component{

    state = {};

    componentDidMount = () => {
        if (this.props.taxonomy === null) {
            this.props.getTaxonomies();
        }
    };


    render()
    {
        return (
            <Page
                title={this.props.taxonomy.attributes.label}
            >
                <Table
                    data={this.props.tags}
                    tdClick={(row) => this.props.history.push('/admin/tags/' + row.original.id)}
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
            </Page>
        );
    }
}

const mapStateToProps = (state, props) => {
    // route id
    let id = props.match.params.taxonomy;

    let taxonomy = null;
    let tags = [];
    if (state.taxonomies.index.length) {
        taxonomy = state.taxonomies.index.find(element => element.id == id);
        tags = state.taxonomies.tags.filter(element => element.attributes.taxonomy_id == id);
    }

    return {taxonomy, tags};
};

export default connect(mapStateToProps, { getTaxonomies })(Taxonomy);