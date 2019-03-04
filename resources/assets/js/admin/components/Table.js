import React, { Component } from "react";
import ReactTable from "react-table";

export class Table extends Component{
    render(){        
        return(
            <div id="page">
                 <ReactTable
                    data={this.props.data}
                    columns={this.props.columns}
                    showPagination={true}
                    defaultPageSize={20}
                    pageSizeOptions={[10, 20, 30, 50, 100]}
                    multiSort={true}
                    filterable={true}
                    rowsText=""
                    nextText=">"
                    previousText="<"
                    getTdProps={(state, rowInfo, column, instance)=>{
                        return {
                            onClick: () => this.props.tdClick(rowInfo)
                        }                        
                    }}
                />
            </div>
        );
    }
}