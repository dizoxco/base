import React, { Component } from "react";
import TinyMCE from 'react-tinymce';

export class Editor extends Component{
    render(){
        return (
            <div className="w-full p-2">
                <TinyMCE
                    content="<p>This is the initial content of the editor</p>"
                    config={{
                        plugins: 'autolink link image lists print preview directionality',
                        directionality: 'rtl',
                        toolbar: "bold italic underline strikethrough justifyleft | alignleft aligncenter alignright | bullist numlist | ltr rtl",
                        branding: false,
                        content_style: "body {font-family: IRANSans; line-height: 2.2}",
                        height: 250,
                        language: 'fa_IR',
                    }}
                    onChange={this.handleEditorChange}
                />
            </div>
        );
    }
}