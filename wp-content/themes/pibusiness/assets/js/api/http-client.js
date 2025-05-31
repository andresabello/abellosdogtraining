import axios from 'axios'

export default class HttpClient {

    constructor () {

        this.client = axios.create({
            baseURL: wpApiSettings.root,
            timeout: 1000,
            headers: {'X-WP-Nonce': wpApiSettings.nonce},
        })
    }

    post (url, data) {
        return this.request('post', url, data)
    }

    put (url, data) {
        return this.request('put', url, data)
    }

    delete (url) {
        return this.request('delete', url)
    }

    get (url) {
        return this.request('get', url)
    }

    getPost (id) {
        return this.get(`wp/v2/posts/${id}`)
    }

    getMedia (id) {
        return this.get(`/wp/v2/media/${id}`)
    }

    request (type, url, data) {
        if (data) {
            return new Promise((resolve, reject) => {
                this.client[type](url, data).then(response => {
                    resolve(response)
                }).catch((error) => {
                    reject(error.response)
                })
            })
        }

        return new Promise((resolve, reject) => {
            this.client[type](url).then(response => {
                resolve(response)
            }).catch((error) => {
                reject(error.response)
            })
        })

    }
}
