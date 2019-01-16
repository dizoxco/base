export const Changer = (component, e) => {
    let form = {};
    if(component.state !== null){
        if(component.state.form !== null){
            form = component.state.form;
        }
    }
    // console.log(form);
        
    component.setState({
        form: {
            ...form,
            [e.target.name]: e.target.value
        }        
    });
}