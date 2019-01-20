import React, { Component } from "react";
import { connect } from "react-redux";

import { getPosts } from "../actions"
import { Page, Table } from "../components";

class Posts extends Component{

    state = {}

    componentDidMount = () => {
        this.props.getPosts();
    }

    tdClick = (rowInfo) => {
        this.setState({
            redirect: '/admin/posts/' + 1
        })
    }

    render(){
        return(
            <Page                
                title='مطالب'
                button={{
                    label: 'save'
                }}
                tabs={['نمایش', 'ویرایش', 'پیرایش نیما']}
                redirect={this.state.redirect}
                onChange={(value) => this.setState({tab: value})}
            >   
                <Table
                    data={this.props.posts}
                    columns={[
                        {
                            Header: 'id',
                            accessor: 'id',
                            width: 70
                        },
                        {
                            Header: 'email',
                            accessor: 'attributes.title'
                        }
                    ]}
                    tdClick={this.tdClick}
                />
            </Page>
        );
    }
}

const mapStateToProps = state => {
    return {
        posts: state.posts.posts
    };
};

export default connect(mapStateToProps, { getPosts })(Posts);