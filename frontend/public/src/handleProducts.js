import {HandleTypes} from './handleTypes.js';

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
            credentials: "omit",
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

    deleteProduct(product, thenCall) {
        fetch(`${this.backEndUrl}/api/product/${product.id}`, {
            method: 'delete',
            credentials: 'omit'
        })
            .then(() => thenCall("Produto excluido com sucesso"))
            .catch(err => {
                console.log(err)
            });
    }
}

class ViewProducts {
    constructor(handleProducts) {
        this.handleProducts = handleProducts;
    }

    thenFetchProductsLoadTable(products) {

        products = products.reverse();

        let tableHeadHtml = '<thead>\n' +
            '<tr>\n' +
            '<th></th>\n' +
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

            tableTrHtml += `<tr style="cursor: pointer;" data-tr-product='${JSON.stringify(product)}'>\n` +
                `<td><i class="material-icons tiny">mouse</i></td>\n` +
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

        $( "#table-products tbody tr" ).on( "click", function() {
            let data = $(this).data('tr-product');

            handleClickProductList(data);
        });
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

        let product = this.viewProducts.getObjectProductFromForm(event);

        this.viewProducts.handleProducts.saveProduct(product, message => {
            alert(message);
            window.location.reload();
        });
    }

    deleteProduct(event) {
        event.preventDefault();

        let product = this.viewProducts.getObjectProductFromForm(event);

        this.viewProducts.handleProducts.deleteProduct(product, message => {
            alert(message);
            window.location.reload();
        });
    }

    getForm(event) {
        return $(event.target).closest("form")[0];
    }

    getObjectProductFromForm(event) {

        let form = this.getForm(event);

        let id = $(form).find('[name="id"]').val();
        let name = $(form).find('[name="name"]').val();
        let description = $(form).find('[name="description"]').val();
        let type = $(form).find('[name="type"]').val();

        let product = {
            id,
            name,
            description
        };

        if (type === null)
            product.type = '';

        return product;
    }
}

export default class BootstrapProductsView {

    constructor(backEndUrl) {
        this.backEndUrl = backEndUrl;
    }

    bootstrap() {
        this.handleProducts = new HandleProducts(this.backEndUrl);
        this.viewProducts = new ViewProducts(this.handleProducts);

        this.listProducts();
        this.initFormProduct();
        this.actionSubmitNewProduct();
        this.actionSubmitDeleteProduct();
    }

    listProducts() {
        this.handleProducts.fetchProducts(this.viewProducts.thenFetchProductsLoadTable);
    }

    initFormProduct() {
        let types = new HandleTypes(this.backEndUrl);

        types.fetchTypes(this.viewProducts.thenInitPluginSelect);
    }

    actionSubmitNewProduct() {
        let btnSaveNewProduct = document.getElementById('save-product');

        btnSaveNewProduct.addEventListener('click', {
            handleEvent: this.viewProducts.saveNewProduct,
            viewProducts: this.viewProducts
        });
    }

    actionSubmitDeleteProduct() {
        let btn = document.getElementById('delete-product-btn');

        btn.addEventListener('click', {
            handleEvent: this.viewProducts.deleteProduct,
            viewProducts: this.viewProducts
        });
    }
}

function handleClickProductList(product) {
    $('form [name="id"]').val(product.id);
    $('form [name="name"]').val(product.name);
    $('form [name="name"]').focus();
    $('form [name="description"]').val(product.description);
    $('form [name="description"]').focus();
    $('form [name="type"]').val(product.type.id);
    $('form [name="type"] option:selected').attr("selected");
}