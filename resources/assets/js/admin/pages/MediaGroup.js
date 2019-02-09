import React, {Component} from "react";
import {connect} from "react-redux";
import axios from 'axios';
import {getMediaGroup, getMediaGroups, addMedia,getPosts, getUsers} from "../actions"
import {Page} from "../components";
import LinearProgress from "@material-ui/core/es/LinearProgress/LinearProgress";
import routes from '../routes';
import {getCookie} from "../../helpers";

class MediaGroup extends Component {

    state = {selectedFiles: [], uploaded: []};

    componentDidMount = () => {
        if (this.props.mediagroup == null) this.props.getMediaGroups();
    };

    startUpload = () => {

        Object.keys(this.state.selectedFiles).forEach(async key => {
            const data = new FormData();

            data.append('media', this.state.selectedFiles[key]);

            await this.uploading(data, key);

        });
    };

    uploading = (file, key) => {

        const mediagroup = this.props.match.params.mediagroup;

            axios.post(routes('api.mediagroups.store', [mediagroup]), file, {
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
                },

            }).then(response => {
                this.props.addMedia(response.data.data ,mediagroup);
            }).catch(errors => {
                console.log(errors);
            }).finally(() => {
                console.log(this.state.selectedFiles[key].name, 'uploaded');
            });

    };

    handleSelectedFile = event => {
        this.setState({
            selectedFiles: event.target.files,
        }, () => {
            this.startUpload();
        });
    };


    render() {
        if (this.props.media.length == 0) this.props.getMediaGroup(1);

        let media = this.props.media.map((medium) => {
            // console.log(medium);

            return <div className="w-1/12 p-1" key={medium.id}><p>{medium.attributes.name}</p>
                {/*<img src={medium.attributes.conversions.thumb.url}/>*/}
            </div>;
        });

        const files = Object.keys(this.state.selectedFiles).map(key => {
            return (<div className="w-1/12 p-1" key={'img_' + key}>

                <img src={URL.createObjectURL(this.state.selectedFiles[key])} width={150} height={150}/>


                <label
                    className="text-center"> {this.state.uploaded[key] ? Math.round(this.state.uploaded[key]) : 0} %</label>
                <LinearProgress variant="determinate"
                                value={this.state.uploaded[key] ? Math.round(this.state.uploaded[key]) : 0}/>
            </div>)
        });


        return (
            <Page
                title='رسانه'
                button={{
                    label: 'save'
                }}
                onChange={(value) => this.setState({tab: value})}
            >
                <p>
                    <input type="file" multiple={'multiple'} onChange={this.handleSelectedFile}/>
                </p>
                <div className="flex flex-wrap">
                    {files}
                </div>
                <div className="flex flex-wrap">
                    {media}
                </div>
            </Page>
        );
    }
}

const mapStateToProps = (state, props) => {
    var mediagroup = (state.media.mediagroups.length) ? state.media.mediagroups.find(element => element.id == props.match.params.mediagroup) : null;
    return {
        mediagroup,
        media: (mediagroup == null || mediagroup.media === undefined) ? [] : mediagroup.media
    };
};

export default connect(mapStateToProps, {getMediaGroup, getMediaGroups, getPosts, getUsers , addMedia})(MediaGroup);