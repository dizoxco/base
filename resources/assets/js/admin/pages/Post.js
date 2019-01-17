import React, { Component } from "react";
import { connect } from "react-redux";

import { getPosts } from "../actions"
import { Page, Table } from "../components";

class Post extends Component{

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
        console.log(this.props.match.params.user);
        console.log(this.props.post || 'dd');
        
        return(
            <Page                
                // title={this.props.post.attributes.title}
                title='dd'
                button={{
                    label: 'save'
                }}
                tabs={['نمایش', 'ویرایش', 'پیرایش نیما']}
                redirect={this.state.redirect}
                loading={this.props.post == undefined}
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
        posts: state.posts.posts,
        post: state.posts.posts.find( element => element.id == 1 )
    };
};

export default connect(mapStateToProps, { getPosts })(Post);