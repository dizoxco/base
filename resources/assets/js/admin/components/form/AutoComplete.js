import React from 'react';
import Select from 'react-select';
import makeAnimated from 'react-select/lib/animated';
import { array } from 'prop-types';


export class AutoComplete extends React.Component {

    handleChange = (selectedOption) => {        
        if(Array.isArray(this.props.value)){
            var result = [];
            if (typeof this.props.value[0] == "object") {
                result = selectedOption.map( opt =>  this.props.data.find( d => this.deep_value(d, this.props.accessors.value) == opt.value) ) 
            }else{
                
                result = selectedOption.map( opt => opt.value)
            }
        }else{
            if (typeof this.props.value == "object") {
                var result = this.props.data.find(d => this.deep_value(d, this.props.accessors.value) == selectedOption.value);
            }else{
                var result = selectedOption.value;
            }
        }
        
        if (this.props.onChange != undefined) {
            this.props.onChange(result);
        }
    };

    deep_value = (obj, path) => {
        return path
            .replace(/\[|\]\.?/g, '.')
            .split('.')
            .filter(s => s)
            .reduce((acc, val) => acc && acc[val], obj);
    }

    render() {
        var data = [];
        data = this.props.data.map( opt => ({
            value: this.deep_value(opt, this.props.accessors.value),
            label: this.deep_value(opt, this.props.accessors.label)
        }))

        if (Array.isArray(this.props.value)) {
            var value = [];
            if (data.length > 0 && this.props.value.length > 0) {
                if (typeof this.props.value[0] == "object") {
                    value = this.props.value.map( v => ({
                        value: this.deep_value(v, this.props.accessors.value),
                        label: this.deep_value(v, this.props.accessors.label)
                    }) )
                }else{
                    value = this.props.value.map( v => data.find( d => d.value == v))
                }
            }
        }else{
            var value = null;
            if (data.length > 0 && this.props.value) {
                if (typeof this.props.value == "object") {
                    value = data.find(d => d.value == this.deep_value(this.props.value, this.props.accessors.value) )
                }else{
                    value = data.find(d => d.value == this.props.value)
                }
            }
        }

        if (data.length == 0) {
            return <div />
        }

        let className = (this.props.half)? "w-1/2 p-2": "w-full p-2";
        return (
            <div className={className}>
                <Select
                    value={value}
                    onChange={this.handleChange}
                    options={data}
                    isMulti={Array.isArray(this.props.value)}
                    components={makeAnimated()}
                    // closeMenuOnSelect={false}
                />
            </div>
        );
    }
}