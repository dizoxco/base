import React, {Component} from "react";
import {connect} from "react-redux";

import { validateTaxonomy } from "../actions"
import { reduxCopier, reduxDeleter, reduxGetter, reduxReseter, reduxRestorer, reduxSeter, reduxStorer } from "../../helpers";
import {Button, Form, NotFound, Page, Table, Text} from "../components";

class Taxonomy extends Component {

    state = {        
        activeTabIndex: (this.props.taxonomy.id == 0)? 1: 0
    }

    componentDidMount = () => {
        if(this.props.taxonomy != undefined){
            if (this.props.taxonomy.id === undefined) this.props.reduxGetter('taxonomy');
            // if (this.props.tags.length === 0) this.props.reduxGetter('tag');
        }
    }; 

    render() {
        if (this.props.taxonomy == undefined) {
            return <NotFound/>
        }
        return (
            <Page
                title={this.props.taxonomy.attributes.label}
                tabs={['نمایش', 'ویرایش اطلاعات']}
                tab={this.state.activeTabIndex}
                redirect={this.state.redirect}
                loading={this.props.taxonomy == null}
                onChange={(activeTabIndex) => this.setState({activeTabIndex})}
                buttons={<div>
                    <Button 
                        type="icon"
                        icon="save"
                        visible={!this.props.trashed}
                        disabled={!this.props.edited}
                        onClick={() => this.props.reduxStorer(this.props.taxonomy)} 
                    />
                    <Button 
                        type="icon"
                        icon="restore"
                        disabled={!(this.props.edited || this.props.trashed) }
                        onClick={() => this.props.trashed? 
                            this.props.reduxReseter(this.props.taxonomy):
                            this.props.reduxReseter(this.props.taxonomy)
                        } 
                    />
                    <Button 
                        type="icon" 
                        icon="delete"
                        visible={!this.props.trashed}
                        onClick={() => this.props.reduxDeleter(this.props.taxonomy, () => this.props.history.push('/admin/taxonomies'))} 
                    />
                    <Button 
                        type="icon"
                        icon="file_copy"
                        onClick={() => this.props.reduxCopier(this.props.taxonomy, () => this.props.history.push('/admin/taxonomies/create'))} 
                        visible={this.props.taxonomy.id && !this.props.trashed}
                    />
                </div>}
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
                                Header: 'نامک',
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
                        id={this.props.taxonomy.id}
                        label='نام گروه'
                        value={this.props.taxonomy.attributes.group_name}
                        disabled={this.props.taxonomy.id == undefined}
                        half
                        onChange={(e) => this.props.reduxSeter(this.props.taxonomy, 'attributes.group_name', e.target.value)}
                        // onBlur = {() => this.props.validateTaxonomy(this.props.taxonomy.id)}
                        errors={(this.props.taxonomy.validation) ? this.props.taxonomy.validation.group_name : ''}
                    />
                    <Text
                        label='نامک'
                        value={this.props.taxonomy.attributes.slug}
                        half
                        onChange={(e) => this.props.reduxSeter(this.props.taxonomy, 'attributes.slug', e.target.value)}
                        // onBlur = {() => this.props.validateTaxonomy(this.props.taxonomy.id, 'slug')}
                        errors={(this.props.taxonomy.validation) ? this.props.taxonomy.validation.slug : ''}
                    />
                    <Text
                        label='برچسب'
                        value={this.props.taxonomy.attributes.label}
                        half
                        onChange={(e) => this.props.reduxSeter(this.props.taxonomy, 'attributes.label', e.target.value)}
                        // onBlur = {() => this.props.validateTaxonomy(this.props.taxonomy.id, 'label')}
                        errors={(this.props.taxonomy.validation) ? this.props.taxonomy.validation.label : ''}
                    />
                </Form>
            </Page>
        );
    }
}

const mapStateToProps = (state, props) => {
    // route id
    let id = props.match.params.taxonomy;
    let taxonomy = null;
    // let tags = state.tag.index.filter(element => element.attributes.taxonomy_id == id);


    // if (id === 'create') {
    //     taxonomy = state.taxonomy.create;
    // } else {
    //     if (state.taxonomy.index.length == 0) {
    //         taxonomy = state.taxonomy.init;
    //     } else {
    //         taxonomy = state.taxonomy.index.find(element => element.id == id);
    //     }
    // }

    if (id == 'create') taxonomy = state.taxonomy.create;
    else if(state.taxonomy.index.length == 0) taxonomy = state.taxonomy.init;
    else taxonomy = state.taxonomy.index.find( element => element.id == id ); 

    if (taxonomy == undefined) taxonomy = state.taxonomy.trash.find(element => element.id == id)

    let trashed = ( taxonomy != undefined && taxonomy.attributes.deleted_at != null);
    // let edited = ( taxonomy != undefined && (taxonomy.oldAttributes != undefined || taxonomy.oldRelations != undefined));
    let edited = ( taxonomy != undefined && (taxonomy.oldAttributes != undefined ));
    let tags = state.tag.index.length? state.tag.index.filter(tag => tag.attributes.taxonomy_id == 1): []

    return {taxonomy, tags, trashed, edited};
};
 
export default connect(
    mapStateToProps,
    {reduxCopier, reduxDeleter, reduxGetter, reduxReseter, reduxRestorer, reduxSeter, reduxStorer,
            validateTaxonomy  }
    )(Taxonomy);