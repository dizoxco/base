import React, {Component} from "react";
import {connect} from "react-redux";

import {copyUser, deleteUser, getUsers, resetUser, restoreUser, setUser, storeUser, updateUser} from "../actions"
import {Button, File, Form, Page, Show, Text} from "../components";
import routes from "../routes";

class User extends Component {

    state = {activeTabIndex: (this.props.user.id == 0) ? 1 : 0};

    componentDidMount() {
        if(this.props.user != undefined){
            if (this.props.user.id == undefined || this.props.user.attributes == undefined) {
                this.props.getUsers();
            }
        }
    }

    render() {
        return (
            <Page
                title={this.props.user.attributes.name}
                buttons={<div>
                    <Button
                        type="icon"
                        icon="save"
                        visible={!this.props.trashed}
                        disabled={!this.props.edited}
                        onClick={() => this.props.user.id ? this.props.updateUser(this.props.user):  this.props.storeUser(this.props.user)}
                    />
                    <Button
                        type="icon"
                        icon="restore"
                        disabled={!(this.props.edited || this.props.trashed) }
                        onClick={() => this.props.trashed ?
                            this.props.restoreUser(this.props.user.id):
                            this.props.resetUser(this.props.user.id)
                        }
                    />
                    <Button
                        type="icon"
                        icon="delete"
                        visible={!this.props.trashed}
                        onClick={() => this.props.deleteUser(this.props.user.id, () => this.props.history.push('/admin/users'))}
                    />
                    <Button
                        type="icon"
                        icon="file_copy"
                        onClick={() => this.props.copyUser(this.props.user.id, () => this.props.history.push('/admin/users/create'))}
                        visible={this.props.user.id && !this.props.trashed}
                    />
                </div>}
                tabs={
                    this.props.user.id === 0 ? ['نمایش','افزودن کاربر'] : ['نمایش', 'ویرایش اطلاعات']
                }
                tab={this.state.activeTabIndex}
                redirect={this.state.redirect}
                onChange={(activeTabIndex) => this.setState({activeTabIndex})}
            >
                <Form show={this.state.activeTabIndex == 0}>
                    <Show label="نام">{this.props.user.attributes.name}</Show>
                    <Show label="ایمیل">{this.props.user.attributes.email}</Show>
                </Form>
                <Form show={this.state.activeTabIndex == 1}>
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
                        label='تلفن همراه'
                        value={this.props.user.attributes.mobile}
                        half
                        onChange={(e) => this.props.setUser(this.props.user.id, {mobile: e.target.value})}
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
        )
    }
}
 
const mapStateToProps = (state, props) => {
    let user;
    let id = props.match.params.user;

    if (id == 'create') {
        user = state.users.create;
    } else if (state.users.index.length == 0) {
        user = state.users.init;
    } else {
        user = state.users.index.find( element => element.id == id );
    }

    if (user == undefined) {
        user = state.users.trash.find( element => element.id == id );
    }

    let trashed = ( user != undefined && user.attributes.deleted_at != null);
    let edited = ( user != undefined && (user.oldAttributes != undefined || user.oldRelations != undefined));

    return {user, trashed, edited};
};

export default connect(
    mapStateToProps,
    {copyUser, deleteUser, getUsers, resetUser, restoreUser, setUser, storeUser, updateUser}
    )(User);