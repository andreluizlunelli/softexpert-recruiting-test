<?php require_once './header.php'; ?>
<body>
<?php require_once './nav.php'; ?>
<div class="container">
    <form style="margin-top: 18px;">
        <div class="grey lighten-3" style="border: 1px solid #e0e0e0">
            <div class="row">
                <div class="col s12">
                    <h3 class="light-blue-text text-darken-1">Tela de vendas</h3>
                </div>
            </div>
            <div class="row">
                <div class="col s12">
                    <button class="btn green lighten-1 waves-effect waves-light" type="button" id="buy-btn">Efetuar compra</button>
                </div>
            </div>
            <div class="row">
                <div class="col s12">
                    <div class="row">
                        <div class="input-field col s4">
                            <i class="material-icons prefix">shopping_cart</i>
                            <input type="text" id="autocomplete-input" class="autocomplete">
                            <label for="autocomplete-input">Inserir nome mercadoria</label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col s6">
                    <h4 class="light-blue-text text-darken-1">Carrinho de compras</h4>
                </div>
                <div class="col s6" id="header-div-tax-coupon" style="display: none">
                    <h4 class="light-blue-text text-darken-1">Total</h4>
                </div>
            </div>
            <div class="row">
                <div class="col s6">
                    <div id="table-products-cart">
                        <h6>Seu carrinho está vazio.</h6>
                    </div>
                </div>
                <div class="col s6">
                    <div class="collection" id="collection-totals" style="display: none">
                        <p class="collection-item"><span id="span-total-paid" class="badge">R$ 34,50</span>Total compra</p>
                        <p class="collection-item"><span id="span-tax-paid" class="badge yellow">R$ 30,99</span>Total impostos</p>
                        <p class="collection-item" id="span-itens-header">Itens</p>
                        <p class="collection-item total-item-paid"><span class="badge">R$ 4,50</span><span class="badge yellow">R$ 2,30</span>&nbsp;&nbsp;Cerveja</p>
                        <p class="collection-item total-item-paid"><span class="badge">R$ 3,20</span><span class="badge yellow">R$ 1,16</span>&nbsp;&nbsp;Refri</p>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<script type="module" src="src/handleSales.js"></script>
<script type="module">
    import BootstrapSalesView from './src/handleSales.js';

    document.addEventListener('DOMContentLoaded', () => new BootstrapSalesView('http://localhost:81').bootstrap());
</script>
</body>
</html>