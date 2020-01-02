import {Types} from './types.js';

export class HandleProducts {

    constructor(backEndUrl) {
        this.backEndUrl = backEndUrl;
    }

    fetchProducts(thenCall) {
        fetch(`${this.backEndUrl}/api/product`)
            .then(response => response.json())
            .then(data => {

                thenCall(data);

            })
            .catch(err => {
                console.log(err)
            });
    }

    saveProduct(product, thenCall) {
        let formData = new FormData();

        formData.append('type', product.type);
        formData.append('name', product.name);
        formData.append('description', product.description);

        let data = new URLSearchParams(formData);

        fetch(`${this.backEndUrl}/api/product`, {
            method: 'post',
            headers: {
                "Content-Type": "application/x-www-form-urlencoded"
            },
            body: data
        })
            .then(response => response.json())
            .then(data => {

                thenCall("Produto salvo com sucesso");

            })
            .catch(err => {
                console.log(err)
            });
    }
}

class ViewProducts {

    thenFetchProductsLoadTable(products) {

        products = products.reverse();

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

    thenInitPluginSelect(types) {
        let elems = document.querySelectorAll('select');

        for (let i in types) {
            let type = types[i];

            $('#type-product').append(new Option(type.name, type.id));
        }

        M.FormSelect.init(elems);
    }

    saveNewProduct(event) {
        event.preventDefault();

        let form = $(event.target).closest("form")[0];

        let name = $(form).find('[name="name"]').val();
        let description = $(form).find('[name="description"]').val();
        let type = $(form).find('[name="type"]').val();

        let product = {
            name,
            description,
            type
        };

        this.handleProducts.saveProduct(product, message => {
            alert(message);
            window.location.reload();
        });
    }
}

class BootstrapProductsView {

    constructor(backEndUrl) {
        this.backEndUrl = backEndUrl;
    }

    bootstrap() {
        this.viewProducts = new ViewProducts();

        this.listProducts();
        this.initFormProduct();
        this.actionSubmitNewProduct();
    }

    listProducts() {
        this.handleProducts = new HandleProducts(this.backEndUrl);

        this.handleProducts.fetchProducts(this.viewProducts.thenFetchProductsLoadTable);
    }

    initFormProduct() {
        let types = new Types(this.backEndUrl);

        types.fetchTypes(this.viewProducts.thenInitPluginSelect);
    }

    actionSubmitNewProduct() {
        let btnSaveNewProduct = document.getElementById('save-product');

        btnSaveNewProduct.addEventListener('click', {
            handleEvent: this.viewProducts.saveNewProduct,
            handleProducts: this.handleProducts
        });
    }
}

document.addEventListener('DOMContentLoaded', function() {
    new BootstrapProductsView('http://localhost:81').bootstrap();
});

