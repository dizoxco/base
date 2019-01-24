import { getCookie } from './'
import Axios from 'axios';

export const getting = (url) => {
    const axiosPostConfig = {
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'Content-Type': 'application/json',
            'Authorization': 'Bearer ' + getCookie('token')
        }
    };
    return Axios.get(url, axiosPostConfig);
}

export const posting = (url, args={}) => {
    const axiosPostConfig = {
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'Content-Type': 'application/json',
            'Authorization': getCookie('token')
        }
    };
    return Axios.post(url, args, axiosPostConfig);
}