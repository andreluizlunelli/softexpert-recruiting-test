
export class Products {

    constructor(backEndUrl) {
        this.backEndUrl = backEndUrl;
        this.rawProducts = [];
    }

    fetchProducts(thenCall) {
        fetch(`${this.backEndUrl}/api/product`)
            .then(response => {
                return response.json()
            })
            .then(data => {

                this.rawProducts = data;

                thenCall(data);

            })
            .catch(err => {
                console.log(err)
            });
    }
}

class ViewProducts {

    thenFetchProductsLoadTable(products) {
        console.log(products);

        let valuesAutoComplete = {};
        for (let i in products) {
            valuesAutoComplete[products[i].name] = null;
        }

        let options = {
            data: valuesAutoComplete
        };

        let elems = document.querySelectorAll('.autocomplete');

        this.instances = M.Autocomplete.init(elems, options);
    }
}

class BootstrapProductsView {

    constructor(backEndUrl) {
        this.backEndUrl = backEndUrl;
    }

    bootstrap() {

        let viewProducts = new ViewProducts();

        let products = new Products(this.backEndUrl);
        products.fetchProducts(viewProducts.thenFetchProductsLoadTable);

    }
}

document.addEventListener('DOMContentLoaded', function() {
    new BootstrapProductsView('http://localhost:81').bootstrap();
});

