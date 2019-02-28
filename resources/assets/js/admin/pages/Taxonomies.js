import React, {Component} from "react";
import {connect} from "react-redux";

import { getTaxonomies } from "../actions"
import {Page, Table} from "../components";

class Taxonomies extends Component{

    state = {};

    componentDidMount = () => {
        if (this.props.taxonomies.length == 0) {
            this.props.getTaxonomies();
        }
    };

    render(){
        return(
            <Page
                title='گروه های تگ'
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
                            width: 100,
                        },
                        {
                            Header: 'اسلاگ',
                            width: 100,
                            accessor: 'attributes.slug',
                        },
                        {
                            Header: 'برچسب',
                            width: 100,
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
        tags: state.taxonomies.tags,
    };
};

export default connect(mapStateToProps, { getTaxonomies })(Taxonomies);