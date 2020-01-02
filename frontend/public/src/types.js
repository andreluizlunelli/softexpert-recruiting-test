export class Types {
    constructor(backEndUrl) {
        this.backEndUrl = backEndUrl;
        this.rawTypes = [];
    }

    fetchTypes(thenCall) {
        fetch(`${this.backEndUrl}/api/type-product`)
            .then(response => {
                return response.json()
            })
            .then(data => {

                this.rawTypes = data;

                thenCall(data);

            })
            .catch(err => {
                console.log(err)
            });
    }
}