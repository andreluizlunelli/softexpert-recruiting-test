export class HandleTypes {
    constructor(backEndUrl) {
        this.backEndUrl = backEndUrl;
    }

    fetchTypes(thenCall) {
        fetch(`${this.backEndUrl}/api/type-product`)
            .then(response => {
                return response.json()
            })
            .then(data => thenCall(data))
            .catch(err => {
                console.log(err)
            });
    }

    saveType(type, thenCall) {
        let formData = new FormData();

        formData.append('name', type.name);
        formData.append('tax_percentage', type.tax_percentage);

        let data = new URLSearchParams(formData);

        fetch(`${this.backEndUrl}/api/type-product`, {
            method: 'post',
            credentials: "omit",
            headers: {
                "Content-Type": "application/x-www-form-urlencoded"
            },
            body: data
        })
            .then(data => {

                thenCall("Tipo de produto salvo com sucesso");

            })
            .catch(err => {
                console.log(err)
            });

    }
}

class ViewTypes {

    constructor(handleTypes) {
        this.handleTypes = handleTypes;
    }

    thenFetchTypesLoadTable(types) {

        types = types.reverse();

        let tableHeadHtml = '<thead>\n' +
            '<tr>\n' +
            '<th></th>\n' +
            '<th>Identificador</th>\n' +
            '<th>Nome</th>\n' +
            '<th>Imposto produto</th>\n' +
            '<th>Criado em</th>\n' +
            '<th>Atualizado em</th>\n' +
            '</tr>\n' +
            '</thead>';

        let tableTrHtml = '';
        for (let i in types) {
            let type = types[i];

            tableTrHtml += `<tr style="cursor: pointer;" data-tr-type='${JSON.stringify(type)}'>\n` +
                `<td><i class="material-icons tiny">mouse</i></td>\n` +
                `<td>${type.id}</td>\n` +
                `<td>${type.name}</td>\n` +
                `<td>${type.tax_percentage}</td>\n` +
                `<td>${type.created_at}</td>\n` +
                `<td>${type.updated_at}</td>\n` +
                '</tr>'
        }

        let tableBodyHtml = `<tbody>${tableTrHtml}</tbody>`;

        let table = '<table>' + tableHeadHtml + tableBodyHtml + '</table>';

        $('#table-types').append(table);

        $("#table-types tbody tr").on( "click", function() {
            let data = $(this).data('tr-type');

            handleClickTypeList(data);
        });
    }

    saveNewType(event) {
        event.preventDefault();

        let type = this.viewTypes.getObjectTypeFromForm(event);

        this.viewTypes.handleTypes.saveType(type, message => {
            alert(message);
            window.location.reload();
        });
    }

    getForm(event) {
        return $(event.target).closest("form")[0];
    }

    getObjectTypeFromForm(event) {

        let form = this.getForm(event);

        let id = $(form).find('[name="id"]').val();
        let name = $(form).find('[name="name"]').val();
        let tax_percentage = $(form).find('[name="tax_percentage"]').val();

        return {
            id,
            name,
            tax_percentage
        };
    }

}

class BootstrapTypesView {

    constructor(backEndUrl) {
        this.backEndUrl = backEndUrl;
    }

    bootstrap() {
        this.handleTypes = new HandleTypes(this.backEndUrl);
        this.viewTypes = new ViewTypes(this.handleTypes);

        this.listTypes();
        this.actionSubmitNewType();
    }

    listTypes() {
        this.handleTypes.fetchTypes(this.viewTypes.thenFetchTypesLoadTable);
    }

    actionSubmitNewType() {
        let btnSaveNewType = document.getElementById('save-type-btn');

        btnSaveNewType.addEventListener('click', {
            handleEvent: this.viewTypes.saveNewType,
            viewTypes: this.viewTypes
        });
    }
}

function handleClickTypeList(type) {
    $('form [name="id"]').val(type.id);
    $('form [name="name"]').val(type.name);
    $('form [name="name"]').focus();
    $('form [name="tax_percentage"]').val(type.tax_percentage);
    $('form [name="tax_percentage"]').focus();
}

document.addEventListener('DOMContentLoaded', function() {
    new BootstrapTypesView('http://localhost:81').bootstrap();
});
