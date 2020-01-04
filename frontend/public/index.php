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
                    <button class="btn green lighten-1 waves-effect waves-light" type="submit" name="action">Efetuar compra</button>
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
                <div class="col s12">
                    <h4 class="light-blue-text text-darken-1">Carrinho de compras</h4>
                </div>
            </div>
            <div class="row">
                <div class="col s6">
                    <div id="table-products-cart"><!-- não apagar --></div>
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