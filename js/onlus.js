function UploadFile(a, b) {
    let text = "";
    if ($(b).get(0).files.length > 0)
        text = $(b).val().split('\\').pop();
    else
        text = "Nessun file disponibile. Clicca qui per caricare";
    $(a).text(text);
}

function UploadFiles(a, b) {
    let text = "";
    if ($(a).get(0).files.length > 0) {
        var array = $('#RisorseProgetto').get(0).files;
        $.each(array, (i, v) => {
            text += v.name;
            text += "<br>";
        });
    } else {
        text = "Nessun file disponibile. Clicca qui per caricare";
    }
    $(b).html(text);
}

function GeneraInput(num) {
    for (let i = 0; i < num; i++) {
        GeneraPrice();
        GeneraDesc();
    }
}

function GeneraPrice() {
    $('#multiPrice').append('<div class="input-group mt-2"><div class="input-group-prepend"><span class="input-group-text">€</span></div>' +
        '<input type="number" class="form-control" name="txtRicompensaProgetto[]" min="0" value="0"><div class="input-group-append"><span class="input-group-text">.00</span>' +
        '</div></div>');
}

function GeneraDesc() {
    $('#multiDesc').append('<input type="text" class="form-control mt-2" name="txtDescrizionePrezzo[]">');
}

function SelezionaOpzione(id) {
    $('#txtCategoriaProgetto option[value="' + id + '"]').prop('selected', true)
}