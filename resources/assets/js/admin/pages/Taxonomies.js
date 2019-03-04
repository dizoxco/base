import React, {Component} from "react";
import {connect} from "react-redux";

import { getTaxonomies, getTags } from "../actions"
import {Page, Table} from "../components";

class Taxonomies extends Component{

    state = {};

    componentDidMount = () => {
        if (this.props.taxonomies.length === 0) {
            this.props.getTaxonomies();
        }

        if (this.props.tags.length === 0) {
            this.props.getTags();
        }
    };

    render(){
        return(
            <Page
                title='گروه های تگ'

                button={{
                    label: 'گروه تگ جدید',
                    onClick: () => this.props.history.push('/admin/taxonomies/create')
                }}

                onChange={(value) => this.setState({tab: value})}
            >
                <Table
                    data={this.props.taxonomies}
                    tdClick={(r) => this.props.history.push('/admin/taxonomies/' + r.original.id)}
                    columns={[
                        {
                            Header: 'شناسه',
                            accessor: 'id',
                            width: 100
                        },
                        {
                            Header: 'نام گروه',
                            accessor: 'attributes.group_name',
                            width: 150,
                        },
                        {
                            Header: 'اسلاگ',
                            width: 150,
                            accessor: 'attributes.slug',
                        },
                        {
                            Header: 'برچسب',
                            width: 150,
                            accessor: 'attributes.label',
                        }
                    ]}
                />
            </Page>
        );
    }
}

const mapStateToProps = state => {
    return {
        taxonomies: state.taxonomies.index,
        tags: state.tags.index,
    };
};

export default connect(mapStateToProps, { getTaxonomies, getTags })(Taxonomies);