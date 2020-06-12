import axios from 'axios';
import store from '../store/index';

class Api {

    constructor() {
        let token = store.getters["user/getToken"];

        this.http = axios.create({
            baseURL: "/api/", //change ENV //http://cloud8020
            headers: {
                Authorization: 'Bearer ' . token
            }
        });
    };

    getHttp(){
        return this.http;
    }
}

export default new Api();
