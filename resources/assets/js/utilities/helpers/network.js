import Axios from 'axios';
import Network from '../network';


export const getting = (url: string, ...args): Promise => {
    return new Network(url, args).get()
};

export const postingx = (url: string, ...args): Promise => {
    return new Network(url, args).post()
};

export const putting = (url: string, ...args): Promise => {
    return new Network(url, args).put()

};

export const deleting = (url: string, ...args): Promise => {
    return new Network(url, args).delete()
};


export const posting = (url, args) => {
    const axiosPostConfig = {
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'Content-Type': 'application/json'
        }
    };
    return Axios.post(url, args, axiosPostConfig);
}