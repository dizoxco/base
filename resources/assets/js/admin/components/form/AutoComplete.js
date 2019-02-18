import React from 'react';
import Select from 'react-select';
import makeAnimated from 'react-select/lib/animated';


export default class AutoComplete extends React.Component {
    state = {
        selectedOption: null,
    };
    handleChange = (selectedOption) => {
        this.setState({ selectedOption });
        console.log(`Option selected:`, selectedOption);
    };
    render() {
        const { selectedOption } = this.state;

        return (
            <Select
                value={selectedOption}
                onChange={this.handleChange}
                options={this.props.data}
                isMulti
                components={makeAnimated()}
                closeMenuOnSelect={false}
            />
        );
    }
}