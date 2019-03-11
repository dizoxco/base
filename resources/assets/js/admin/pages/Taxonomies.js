import React, {Component} from "react";
import {connect} from "react-redux";

import { reduxGetter } from "../../helpers";
import {Page, Table, Button} from "../components";

class Taxonomies extends Component{

    state = {};

    componentDidMount = () => {
        if (this.props.taxonomies.length === 0) this.props.reduxGetter('taxonomy')
        if (this.props.tags.length === 0) this.props.reduxGetter('tag')
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
        taxonomies: (props.location.pathname == '/admin/taxonomies')? state.taxonomy.index: state.taxonomy.trash,
        tags: state.tag.index,
    };
}; 

export default connect(mapStateToProps, { reduxGetter })(Taxonomies);