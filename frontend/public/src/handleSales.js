import {HandleProducts} from "./handleProducts.js";

class ProductCart {

    constructor(allProductsList) {
        this.allProductsList = allProductsList;
        this.productsOnCart = [];
    }

    insertProductOnCartByName(productName) {
        let allProductNames = allProductsList.map(value => value.name);

        if (!allProductNames.includes(productName)) {
            return;
        }

        let product = allProductsList.find(value => value.name === productName);

        this.addProductOnCart(product);
    }

    addProductOnCart(product) {
        this.productsOnCart.push(product);

        this.makeTableProducts(this.productsOnCart);
    }

    makeTableProducts(productsOnCart) {

        productsOnCart = this.getProductsWithAmount(productsOnCart);

        let tableHeadHtml = '<thead>\n' +
            '<tr>\n' +
            '<th>Nome</th>\n' +
            '<th>Descrição</th>\n' +
            '<th style="text-align: right;">Quantidade</th>\n' +
            '<th style="text-align: right;"></th>\n' +
            '</tr>\n' +
            '</thead>';

        let tableTrHtml = '';
        for (let i in productsOnCart) {
            let product = productsOnCart[i];

            tableTrHtml += `<tr data-tr-product='${JSON.stringify(product)}'>\n` +
                `<td>${product.name}</td>\n` +
                `<td>${product.description}</td>\n` +
                `<td style="text-align: right;">\n` +
                `<span class="badge">${product.amount}</span>` +
                `</td>\n` +
                `<td style="text-align: right;">\n` +
                `<span class="new badge blue add-amount-product" style="cursor: pointer; padding-top: 3px;" data-badge-caption=""><i class="material-icons tiny">exposure_plus_1</i></span>` +
                `<span class="new badge red remove-amount-product" style="cursor: pointer; padding-top: 3px;" data-badge-caption=""><i class="material-icons tiny">exposure_neg_1</i></span>` +
                `</td>\n` +
                '</tr>'
        }

        let tableBodyHtml = `<tbody>${tableTrHtml}</tbody>`;

        let table = '<table>' + tableHeadHtml + tableBodyHtml + '</table>';

        $('#table-products-cart').html('');
        $('#table-products-cart').append(table);
        $('.add-amount-product').on('click', function () {
            let product = $(this).closest('tr').data('tr-product');

            cart.insertProductOnCartByName(product.name);
        });
        $('.remove-amount-product').on('click', function () {
            let product = $(this).closest('tr').data('tr-product');

            cart.removeProductOnCartByName(product.name);
        });
    }

    getProductsWithAmount(productsOnCart) {
        let products = [];

        for (let i in productsOnCart) {
            let product = productsOnCart[i];

            let number = products.indexOf(product);

            product.amount = (number === -1) ? 1 : product.amount +1;

            if (product.amount === 1)
                products.push(product);
        }

        return products;
    }

    removeProductOnCartByName(productName) {
        let allProductNames = allProductsList.map(value => value.name);

        if (!allProductNames.includes(productName)) {
            return;
        }

        let product = allProductsList.find(value => value.name === productName);

        this.removeProductOnCart(product);
    }

    removeProductOnCart(product) {
        let indexOf = this.productsOnCart.indexOf(product);

        this.productsOnCart.splice(indexOf, 1);

        this.makeTableProducts(this.productsOnCart);
    }
}

export default class BootstrapSalesView {

    constructor(backEndUrl) {
        this.backEndUrl = backEndUrl;
        this.handleProducts = new HandleProducts(backEndUrl);
    }

    bootstrap() {
        this.initInputListProducts();
        this.actionBuy();
    }

    initInputListProducts() {
        this.handleProducts.fetchProducts(this.thenSetValuesToAutocompleteInput);
    }

    thenSetValuesToAutocompleteInput(products) {
        let valuesAutoComplete = {};

        allProductsList = products;

        for (let i in products) {
            valuesAutoComplete[products[i].name] = null;
        }

        const options = {
            data: valuesAutoComplete
        };

        let elems = document.querySelectorAll('.autocomplete');

        M.Autocomplete.init(elems, options);

        $('.autocomplete').on('change', function () {
            let productName = $(this).val();

            cart.insertProductOnCartByName(productName);

            $(this).val('');
        });
    }

    actionBuy() {
        let btn = document.getElementById('buy-btn');

        btn.addEventListener('click', {
            handleEvent: this.buy,
            that: this
        });
    }

    buy() {
        let productsAmount = cart.getProductsWithAmount(cart.productsOnCart);

        for (let i in productsAmount) {
            let product = productsAmount[i];

            product.amount * product.
        }
    }
}



export var allProductsList = [];
export var cart = new ProductCart(allProductsList);
window.cart = cart;
