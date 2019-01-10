export default class Cookie {

    setCookie  (key: string, value: string, options: any) {

        const data = new Date(options.expires_at);

        let  expires = "; expires=" + data.toString();

        document.cookie = key + "=" + (value || "") + expires + "; path=/";
    };


    getCookie(name) : ?string {
        let nameEQ = name + "=";
        let ca = document.cookie.split(';');
        for (let i = 0; i < ca.length; i++) {
            let c = ca[i];
            while (c.charAt(0) === ' ')
                c = c.substring(1, c.length);
            if (c.indexOf(nameEQ) === 0)
                return c.substring(nameEQ.length, c.length);
        }
        return null;
    }

    eraseCookie(name) {
        document.cookie = name + '=; expires=Thu, 01 Jan 1970 00:00:01 GMT; path=/;';
    }


};