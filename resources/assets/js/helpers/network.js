import Axios from 'axios';
import {getCookie} from './';

export const getting = (url) => {
    return Axios.get(
        url,
        {
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Content-Type': 'application/json',
                'Authorization': 'Bearer ' + getCookie('token')
            }
        }
    );
}

export const posting = (url, args={}) => {
    return Axios.post(
        url,
        args,
        {
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Content-Type': 'application/json',
                'Authorization': 'Bearer ' + getCookie('token')
            }
        }
    );
}

export const putting = (url, args={}) => {
    return Axios.post(
        url,
        {
            ...args,
            '_method': 'PUT'
        },
        {
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Content-Type': 'application/json',
                'Authorization': 'Bearer ' + getCookie('token')
            }
        }
    );
}

export const deleting = (url, args={}) => {
    return Axios.post(
        url,
        {
            ...args,
            '_method': 'DELETE'
        },
        {
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Content-Type': 'application/json',
                'Authorization': 'Bearer ' + getCookie('token')
            }
        }
    );
}