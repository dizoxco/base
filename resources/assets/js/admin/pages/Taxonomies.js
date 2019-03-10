import React, {Component} from "react";
import {connect} from "react-redux";

import { getTaxonomies, getTags } from "../actions"
import {Page, Table, Button} from "../components";

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

                buttons = {<div>
                    <Button icon="add" type="icon" visible={!this.props.trash} onClick={() => this.props.history.push('/admin/taxonomies/create')} />
                    <Button icon="delete" type="icon" visible={!this.props.trash} onClick={() => this.props.history.push('/admin/taxonomies/trash')} />
                    <Button icon="list" type="icon" visible={this.props.trash} onClick={() => this.props.history.push('/admin/taxonomies')} />
                </div>
                    // label: 'گروه تگ جدید',
                    // onClick: () => this.props.history.push('/admin/taxonomies/create')
                }
                // onChange={(value) => this.setState({tab: value})}
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

const mapStateToProps = (state, props) => {
    return {
        trash: props.location.pathname == '/admin/taxonomies/trash',
        taxonomies: (props.location.pathname == '/admin/taxonomies')? state.taxonomies.index: state.taxonomies.trash,
        tags: state.tags.index,
    };
}; 

export default connect(mapStateToProps, { getTaxonomies, getTags })(Taxonomies);