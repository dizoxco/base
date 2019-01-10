import Axios from 'axios';
import {getToken, routeBinder} from './helpers/index';
import Request from '../request/request';

export default class Network {

    axois = Axios;

    url: String;

    request: Request;

    constructor(requestedUrl: String, params: Array) {

        this.axois.defaults.headers.common['Authorization'] = getToken();

        const {url, request} = routeBinder(requestedUrl, params);

        this.url = url;

        this.request = request;
    }


    get = (): Promise => {

        return this.axois.get(this.url, this.request.getConfig());
    };

    post = (): Promise => {

        return this.axois.post(this.url, this.request.all(), this.request.getConfig());
    };

    put = (): Promise => {

        this.request.merge('_method', 'PUT');

        return this.axois.post(this.url, this.request.all(), this.request.getConfig());
    };

    patch = (): Promise => {

        this.request.merge('_method', 'PATCH');

        return this.axois.post(this.url, this.request.all(), this.request.getConfig());
    };

    delete = (): Promise => {

        return this.axois.delete(this.url, this.request.getConfig());
    };

}