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
                            <label for="autocomplete-input">Mercadoria / código</label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var elems = document.querySelectorAll('.autocomplete');

        fetch('http://localhost:81/api/product')
            .then(response => {
                return response.json()
            })
            .then(data => {

                valuesAutoComplete = {};
                for (i in data) {
                    valuesAutoComplete[data[i].name] = null;
                }

                options = {
                    data: valuesAutoComplete
                };

                var instances = M.Autocomplete.init(elems, options);
            })
            .catch(err => {
                console.log(err)
            });
    });
</script>
</body>
</html>