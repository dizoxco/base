import React, {Component} from "react";
import {connect} from "react-redux";

import {getBusinesses} from "../actions"
import {Button, Icon, Page, Table} from "../components";

class Businesses extends Component{

    componentDidMount = () => {
        if(this.props.businesses.length == 0)
            this.props.getBusinesses();
    };

    render(){ 
        return(
            <Page                
                title='کسب و کارها'
                buttons = {<div>
                    <Button icon="add" type="icon" visible={!this.props.trash} onClick={() => this.props.history.push('/admin/businesses/create')} />
                    <Button icon="delete" type="icon" visible={!this.props.trash} onClick={() => this.props.history.push('/admin/businesses/trash')} />
                    <Button icon="list" type="icon" visible={this.props.trash} onClick={() => this.props.history.push('/admin/businesses')} />
                </div>}
            >
                <Table
                    data={this.props.businesses}
                    tdClick={(row) => this.props.history.push('/admin/businesses/' + row.original.id)}
                    columns={[
                        {
                            Header: 'شناسه',
                            accessor: 'id',
                            width: 150
                        },
                        {
                            Header: 'وضعیت',
                            width: 50,
                            Cell: row => row.original.oldAttributes ? (<Icon icon="edit" />) : '',
                        },
                        {
                            Header: 'برند',
                            width: 300,
                            accessor: 'attributes.brand',
                        }
                    ]}
                />
            </Page>
        );
    }
}

const mapStateToProps = (state, props) => {
    return {
        trash: props.location.pathname == '/admin/businesses/trash',
        businesses: (props.location.pathname == '/admin/businesses') ? state.businesses.index : state.businesses.trash
    };
};

export default  connect(mapStateToProps, { getBusinesses })(Businesses);