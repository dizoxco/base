import React, {Component} from "react";
import {connect} from "react-redux";

import {getUsers, setUser, updateUser , storeUser} from "../actions"
import {File, Form, Page, Show, Text} from "../components";
import routes from "../routes";

class User extends Component {

    state = {
        tab: 0
    };

    componentDidMount() {
        if (this.props.user === null) {
            this.props.getUsers();
        }
    }

    handleClick = () => {
        if (this.props.user.id == 0) {
            this.props.storeUser(this.props.user)
        } else {
            this.props.updateUser(this.props.user)
        }
    };


    render() {
        if (this.props.user === null) {
            return <div>loading ....................</div>
        }

        if (this.props.user === undefined) {
            return <div>undefined ....................</div>
        }

        return (
            <Page
                title={this.props.user.attributes.name}
                button={{
                    label: 'save',
                    onClick: () => this.handleClick()
                }}
                tabs={this.props.user.id === 0 ? ['نمایش', 'افزودن کاربر'] : ['نمایش', 'ویرایش اطلاعات']}
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
                    <File path={routes('api.users.update', [this.props.user.id])} put name="avatar"  />
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
                    <Text
                        label='رمز عبور'
                        value={this.props.user.attributes.password}
                        half
                        type={'password'}
                        onChange={(e) => this.props.setUser(this.props.user.id, {password: e.target.value})}
                    />
                    <Text
                        label='تکرار رمز عبور'
                        value={this.props.user.attributes.password_confirmation}
                        half
                        type={'password'}
                        onChange={(e) => this.props.setUser(this.props.user.id, {password_confirmation: e.target.value})}
                    />

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

export default connect(mapStateToProps, {getUsers, setUser, updateUser ,storeUser})(User);