import React, { Component } from "react";
import { connect } from "react-redux";
import { increment } from "../actions"
import { Button, Text } from "../components"

class Login extends Component{
    render(){
        return(
            <div className="container mx-auto py-10 text-center">
                ورود به پنل مدیریتی
                <br/>
                <br/>
                <br/>
                <Text label="نام کاربری" />
                <br/>
                <br/>
                <Text label="رمز عبور" />
                <br/>
                <br/>
                <Button label="ورود" />
            </div>
        );
    }
}

const mapStateToProps = state => {
    return {
        counter: state.posts.counter
    };
};

export default connect(mapStateToProps, { increment })(Login);