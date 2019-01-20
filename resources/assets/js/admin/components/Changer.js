export const Changer = (component, e, key = 'form') => {
    let form = {};
    if(component.state !== null){
        if(component.state.form !== null){
            form = component.state.form;
        }
    }
        
    component.setState({
        form: {
            ...form,
            [e.target.name]: e.target.value
        }        
    });
}