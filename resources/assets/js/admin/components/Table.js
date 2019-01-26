import React, { Component } from "react";
import ReactTable from "react-table";

export class Table extends Component{
    render(){
        const data = [{
                name: 'omid shojaei',
                age: 29,
                friend: {
                    name: 'Jason Maurer',
                    age: 23,
                }
            },{
                name: 'nima ghadami',
                age: 30,
                friend: {
                    name: 'Jason Maurer',
                    age: 23,
                }
            },{
                name: 'foroogh khademi',
                age: 31,
                friend: {
                    name: 'Jason Maurer',
                    age: 23,
                }
            },{
                name: 'hannane malekzade',
                age: 31,
                friend: {
                    name: 'Jason Maurer',
                    age: 23,
                }
            },{
                name: 'mohammad akbari',
                age: 24,
                friend: {
                    name: 'Jason Maurer',
                    age: 23,
                }
            },{
                name: 'arefeh',
                age: 33,
                friend: {
                    name: 'Jason Maurer',
                    age: 23,
                }
            },{
                name: 'masoud darvishi',
                age: 25,
                friend: {
                    name: 'Jason Maurer',
                    age: 23,
                }
            }
        ];

        const columns = [
            {
                Header: 'Name',
                accessor: 'name' // String-based value accessors!
            },{
                Header: 'Age',
                accessor: 'age',
                Cell: props => <span className='number'>{props.value}</span> // Custom cell components!
            },{
                id: 'friendName', // Required because our accessor is not a string
                Header: 'Friend Name',
                accessor: d => d.friend.name // Custom value accessors!
            },{
                Header: props => <span>Friend Age</span>, // Custom header components!
                accessor: 'friend.age'
            }];
        
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