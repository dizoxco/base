export class RequestBuilder {

    constructor() {
        this.request = {
            data: FormData,
            config: {}
        };
    }

    /**
     *
     *
     * @param request
     *
     * @returns {RequestBuilder}
     */
    builder = (request: Object): void => {

        const formData = new FormData();

        Object.keys(request).map(key => {

            formData.append(key, request[key]);
        });

        this.request = {
            ...this.request,
            data: formData
        };
    };

    /**
     * adding right headers to request base on inputs.
     *
     */
    setHeaders() {
        const header = {
            'content-type': ''
        };

        if (this.exists('file')) {
            header['content-type'] = 'multipart/form-data'
        }


        this.request = {
            ...this.request,
            config: {
                ...this.request.config,
                headers: header
            }
        }
    }

    /**
     * check if input with specific type exists.
     *
     * type : [string , file]
     *
     * @param type
     *
     * @returns {boolean}
     */
    exists = (type: string): boolean => {

        let item = Object.keys(this.request.data).map(key => {

            if (this.request.data[key].constructor.toString() === type)
                return true;
        });

        return item === true;
    }
}


export default class Request extends RequestBuilder {


    build = (data: Object): this => {

        this.builder(data);

        return this
    };

    /**
     * get input form formData
     *
     * @param key
     *
     * @returns {any}
     */

    get = (key: string): any =>{

        return this.request.data.hasOwnProperty(key) ? this.request.data[key] : undefined;
    };


    /**
     * adding data for form
     *
     * @param key
     * @param value
     */
    merge = (key: string, value: any): void => {
        const r = {...this.request.data};
        this.request.data.append(key, value);
    };

    getConfig = (): Object =>{

        return this.request.config;
    };

    /**
     * get inputs form request
     *
     * @returns {FormData}
     */
    all = (): FormData => {

        return this.request.data;
    }

}