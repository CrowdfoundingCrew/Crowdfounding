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