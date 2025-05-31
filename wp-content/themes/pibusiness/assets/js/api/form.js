import Error from './error.js'

export default class Form {

    constructor (data) {

        this.originalData = data

        for (let field in data) {
            this[field] = data[field]
        }

        this.errors = new Error()
        this.client = window.axios
    }

    data () {
        let data = Object.assign({}, this)
        delete data.originalData
        delete data.errors
        return data
    }

    post (url) {
        return this.submit('post', url)
    }

    put (url) {
        return this.submit('put', url)
    }

    get (url) {
        return this.submit('get', url)
    }

    patch (url) {
        return this.submit('patch', url)
    }

    destroy (url) {
        return this.submit('delete', url)
    }

    reset () {
        for (let field in this.originalData) {
            this[field] = ''
        }

        this.errors.clear()
    }

    submit (reqType, url) {
        return new Promise((resolve, reject) => {
            this.client[reqType](url, this.data()).then(response => {
                this.onSuccess()
                resolve(response)
            }).catch(response => {
                this.onFail(response)
                reject(response)
            })
        })
    }

    onSuccess () {
        this.errors.clear()
    }

    onFail (data) {
        this.errors.record(data)
    }

}