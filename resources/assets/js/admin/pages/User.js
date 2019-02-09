import React, {Component} from "react";
import {connect} from "react-redux";

import {getUsers, setUser ,updateUser} from "../actions"
import {Form, Page, Show, Text} from "../components";

class User extends Component {

    state = {
        tab: 0
    };

    componentDidMount() {
        if (this.props.user === null) {
            this.props.getUsers();
        }
    }


    render() {
        if (this.props.user === null) {
            return <div>loading ....................</div>
        }

        if (this.props.user === undefined) {
            return <div>undefined ....................</div>
        }

        return (
            <Page
                // title={this.props.post.attributes.title}
                title={this.props.user.attributes.name}
                button={{
                    label: 'save',
                    onClick: () => this.props.updateUser(this.props.user)
                }}
                tabs={['نمایش', 'ویرایش اطلاعات']}
                tab={this.state.tab}
                redirect={this.state.redirect}
                onChange={(tab) => this.setState({tab})}
            >
                <Form show={this.state.tab == 0}>
                    <Show data={[
                        {label: 'عنوان', value: this.props.user.attributes.name},
                        {label: 'نامک', value: this.props.user.attributes.email},
                    ]}/>
                </Form>
                <Form show={this.state.tab == 1}>
                    <Text
                        label='نام'
                        value={this.props.user.attributes.name}
                        half
                        onChange={(e) => this.props.setUser(this.props.user.id, {name: e.target.value})}
                    />
                    <Text
                        label='ایمیل'
                        value={this.props.user.attributes.email}
                        half
                        onChange={(e) => this.props.setUser(this.props.user.id, {email: e.target.value})}
                    />
                    {/*<Text*/}
                        {/*label='رمز عبور'*/}
                        {/*value={this.props.user.attributes.email}*/}
                        {/*half*/}
                        {/*onChange={(e) => this.props.setUser(this.props.user.id, {email: e.target.value})}*/}
                    {/*/>*/}

                </Form>
            </Page>
        );
    }
}

const mapStateToProps = (state, props) => {
    let user = null;

    if (state.users.index.length) {
        user = state.users.index.find(e => e.id == props.match.params.user);
    }

    return {
        user: user
    };
};

export default connect(mapStateToProps, {getUsers, setUser ,updateUser})(User);