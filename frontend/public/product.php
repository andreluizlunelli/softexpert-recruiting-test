<?php require_once './header.php'; ?>
<body>
<?php require_once './nav.php'; ?>
<div class="container">
    <form style="margin-top: 18px;">
        <div class="grey lighten-3" style="border: 1px solid #e0e0e0">
            <div class="row">
                <div class="col s12">
                    <h3 class="light-blue-text text-darken-1">Tela de produtos</h3>
                </div>
            </div>
            <div class="row">
                <div class="col s12">
                    <div>
                        <form id="form-product" class="col s12" style="margin: 18px">
                            <div class="row">
                                <div class="col s12">
                                    <button class="btn green lighten-1 waves-effect waves-light" type="button" id="save-product">Salvar novo produto</button>
                                    <button class="btn red darken-1 waves-effect waves-light" type="button" id="delete-product-btn" title="Clique em um produto para excluir">Excluir produto</button>
                                    <br>
                                </div>
                            </div>
                            <div class="row">
                                <div class="input-field col s12">
                                    <input id="id-product" type="hidden" name="id">
                                    <input placeholder="Nome produto" id="name-product" type="text" class="validate" name="name">
                                    <label for="name-product">Nome produto</label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="input-field col s12">
                                    <input id="description-product" type="text" class="validate" name="description">
                                    <label for="description-product">Descrição produto</label>
                                </div>
                            </div>
                            <div class="input-field col s12">
                                <select id="type-product" name="type" class="browser-default">
                                    <option value="" disabled selected>Escolha uma categoria para o produto</option>
                                </select>
<!--                                <label for="type-product">Tipo do produto / Imposto cobrado</label>-->
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col s12">
                    <div id="table-products"><!-- não apagar --></div>
                </div>
            </div>
        </div>
    </form>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<script type="module" src="src/handleProducts.js"></script>
</body>
</html>