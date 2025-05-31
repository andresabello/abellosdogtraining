export default class Error {

    constructor() {
        this.errors = {}
    }

    has(field) {
        return this.errors.hasOwnProperty(field)
    }

    any() {
        return Object.keys(this.errors).length > 0
    }

    get(field) {
        if (this.errors[field]) {
            return this.errors[field][0]
        }
    }

    getMessage(field) {
        return this.errors.message[field]
    }

    record(errors) {
        console.log(errors)
        this.errors = errors
    }

    clear(field) {

        if (field) delete this.errors[field]
        this.errors = {}
    }

    toArray() {
        let allErrorsArray = []
        Object.keys(this.errors).map((key) => {
            return allErrorsArray.push({
                location: key, message: this.errors[key][0]
            })
        })
        return allErrorsArray
    }

    toString() {
        JSON.stringify(this.toArray())
    }
}