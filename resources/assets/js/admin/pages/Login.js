import React, { Component } from "react";
import { connect } from "react-redux";
import { getToken } from "../actions"
import { Button, Changer, Text } from "../components"

class Login extends Component{
 
    state = {
        form:{
            service: 'admin@base.com',
            password: '123456'
        }
    }

    render(){
        return(
            <div className="container mx-auto py-10 text-center">
                ورود به پنل مدیریتی
                <br/>
                <br/>
                <br/>
                <Text 
                    label="نام کاربری"
                    onChange={(e) => Changer(this, e)}
                    name="service"
                    value={this.state.form.service}
                />
                <br/>
                <br/>
                <br/>
                <Text
                    label="رمز عبور"
                    onChange={(e) => Changer(this, e)}
                    name="password"
                    value={this.state.form.password}
                    type="password"
                />
                <br/>
                <br/>
                <Button label="ورود" onClick={() => this.props.getToken(this.state.form)} />
            </div>
        );
    }
}

const mapStateToProps = state => {
    return {
        counter: state.users.token
    };
};

export default connect(mapStateToProps, { getToken })(Login);