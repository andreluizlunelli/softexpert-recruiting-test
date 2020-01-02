
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

        let tableHeadHtml = '<thead>\n' +
            '<tr>\n' +
            '<th>Identificador</th>\n' +
            '<th>Nome</th>\n' +
            '<th>Descrição</th>\n' +
            '<th>Tipo produto</th>\n' +
            '<th>Imposto produto</th>\n' +
            '<th>Criado em</th>\n' +
            '<th>Atualizado em</th>\n' +
            '</tr>\n' +
            '</thead>';

        let tableTrHtml = '';
        for (let i in products) {
            let product = products[i];

            tableTrHtml += '<tr>\n' +
                `<td>${product.id}</td>\n` +
                `<td>${product.name}</td>\n` +
                `<td>${product.description}</td>\n` +
                `<td>${product.type.name}</td>\n` +
                `<td>${product.type.tax_percentage}</td>\n` +
                `<td>${product.created_at}</td>\n` +
                `<td>${product.updated_at}</td>\n` +
                '</tr>'
        }

        let tableBodyHtml = `<tbody>${tableTrHtml}</tbody>`;

        let table = '<table>' + tableHeadHtml + tableBodyHtml + '</table>';

        $('#table-products').append(table);
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

