import React, { Component } from "react";
import axios from 'axios';
import {getCookie} from "../../../helpers";
import LinearProgress from "@material-ui/core/es/LinearProgress/LinearProgress";

export class File extends Component{
    state = {selectedFiles: [], uploaded: []};

    handleSelectedFile = event => {
        this.setState({
            selectedFiles: event.target.files,
        }, () => {
            this.startUpload();
        });
    };

    startUpload = () => {
        Object.keys(this.state.selectedFiles).forEach(async key => {
            const data = new FormData();
            if (this.props.put) {
                data.append('_method', 'PUT');
            }
            data.append(this.props.name, this.state.selectedFiles[key]);
            await this.uploading(data, key);
        });
    };

    uploading = (data, key) => {
        axios.post(this.props.path, data, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Content-Type': 'multipart/form-data',
                'Authorization': 'Bearer ' + getCookie('token')
            },
            onUploadProgress: ProgressEvent => {
                const uploaded = {...this.state.uploaded};
                uploaded[key] = (ProgressEvent.loaded / ProgressEvent.total * 100);
                this.setState({
                    uploaded: uploaded
                })
            }
        }).then(response => {
            // this.props.addMedia(response.data.data ,mediagroup);
        }).catch(errors => {
            // console.log(errors);
        }).finally(() => {
            // console.log(this.state.selectedFiles[key].name, 'uploaded');
        });
    };

    render(){
        
        let className = (this.props.half)? "w-1/2 p-2": "w-full p-2"
        
        const files = Object.keys(this.state.selectedFiles).map(key => {
            return (<div className="w-1/12 p-1" key={'img_' + key}>
                <img src={URL.createObjectURL(this.state.selectedFiles[key])} width={150} height={150}/>
                <LinearProgress variant="determinate" value={this.state.uploaded[key] ? Math.round(this.state.uploaded[key]) : 0}/>
            </div>)
        });

        var inputProps = {type: 'file'};
        if (this.props.multiple){
            inputProps.multiple = 'multiple'
        }

        var input = <label className="file-label"><input type="file" {...inputProps} onChange={this.handleSelectedFile}/></label>
        
        if (this.props.multiple == undefined && files.length > 0) {
            input = null;
        }

        return(
            <div className={className}>
                {input}
                {files}
            </div>
        );
    }
}