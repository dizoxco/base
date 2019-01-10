import Cookie from '../cookie'

export const set = (key: string, value: string, options: any): void => {
    new Cookie().setCookie(key, value, options)
};

export const get = (key: string): string => {
    return new Cookie().getCookie(key);
};

export const remove = (key: string): void => {
    new Cookie().eraseCookie(key);
};


export const setToken = (value: string): string => {
    return set('_ct', value);
};

export const getToken = (): string => {
    return get('_ct');
};

export const deleteToken = (): string => {
    return remove('_ct');
};