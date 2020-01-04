<?php require_once './header.php'; ?>
<body>
<?php require_once './nav.php'; ?>
<div class="container">
    <form style="margin-top: 18px;">
        <div class="grey lighten-3" style="border: 1px solid #e0e0e0">
            <div class="row">
                <div class="col s12">
                    <h3 class="light-blue-text text-darken-1">Tela de tipos de produtos</h3>
                </div>
            </div>
            <div class="row">
                <div class="col s12">
                    <div>
                        <form id="form-product" class="col s12" style="margin: 18px">
                            <div class="row">
                                <div class="col s12">
                                    <button class="btn green lighten-1 waves-effect waves-light" type="button" id="save-type-btn">Salvar novo tipo de produto</button>
                                    <button class="btn red darken-1 waves-effect waves-light" type="button" id="delete-type-btn" title="Clique em um tipo para excluir">Excluir tipo de produto</button>
                                    <br>
                                </div>
                            </div>
                            <div class="row">
                                <div class="input-field col s12">
                                    <input id="id-type" type="hidden" name="id">
                                    <input id="name-type" type="text" class="validate" name="name">
                                    <label for="name-type">Nome tipo de produto</label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="input-field col s12">
                                    <input id="tax_percentage-type" type="text" class="validate" name="tax_percentage">
                                    <label for="tax_percentage-type">Imposto produto</label>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col s12">
                    <div id="table-types"><!-- não apagar --></div>
                </div>
            </div>
        </div>
    </form>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<script type="module" src="src/handleTypes.js"></script>
</body>
</html>