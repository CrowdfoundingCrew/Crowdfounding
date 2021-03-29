<?php
require('../config/dalOnlus.php');

if (isset($_GET['ID'])) {
} else {
}

if (isset($_POST['submit'])) {
    $Onlus = 1;
    //Ci vuole la sessione per FKOnlus...
    //DatiProgetto
    $result = INSERTProgetto(
        htmlentities($_POST["txtNomeProgetto"]),
        htmlentities($_POST["txtDescrizioneProgetto"]),
        htmlentities($_POST["txtObiettivoProgetto"]),
        htmlentities($_POST["txtFineProgetto"]),
        htmlentities($_POST["txtCategoriaProgetto"]),
        $Onlus
    );

    if (is_numeric($result)) {
        //ImmagineProgetto
        if (UPLOAD_ERR_OK === $_FILES['ImmagineProgetto']['error']) {
            $uploadDirPhoto = 'assets/profile/';
            $fileNamePhoto = $result . "_" . strval(date('Y-m-d')) . "_" . basename($_FILES['ImmagineProgetto']['name']);
            move_uploaded_file($_FILES['ImmagineProgetto']['tmp_name'], "../" . $uploadDirPhoto . DIRECTORY_SEPARATOR . $fileNamePhoto);
            $profile_path = $uploadDirPhoto . DIRECTORY_SEPARATOR . $fileNamePhoto;
            INSERTRisorsa($profile_path, 0, $result);
        }

        //RisorseProgetto
        $countfiles = count($_FILES['RisorseProgetto']['name']);
        $uploadDirResources = 'assets/resources/';
        for ($i = 0; $i < $countfiles; $i++) {
            if (UPLOAD_ERR_OK === $_FILES['RisorseProgetto']['error'][$i]) {
                $filename = $_FILES['RisorseProgetto']['name'][$i];
                $fileNameResources = $result . "_" . strval(date('Y-m-d')) . "_" . basename($filename);
                move_uploaded_file($_FILES['RisorseProgetto']['tmp_name'][$i], "../" . $uploadDirResources . DIRECTORY_SEPARATOR . $fileNameResources);
                $resources_path = $uploadDirResources . DIRECTORY_SEPARATOR . $fileNameResources;
                INSERTRisorsa($resources_path, 0, $result);
            }
        }

        //Canali Social
        if (!empty(trim($_POST["txtInstagram"]))) {
            INSERTSocial(trim(trim($_POST["txtInstagram"])), "Instagram", $result);
        }

        if (!empty(trim($_POST["txtFacebook"]))) {
            INSERTSocial(trim($_POST["txtFacebook"]), "Facebook", $result);
        }

        if (!empty(trim($_POST["txtTwitter"]))) {
            INSERTSocial(trim($_POST["txtTwitter"]), "Twitter", $result);
        }

        if (!empty(trim($_POST["txtTelegram"]))) {
            INSERTSocial(trim($_POST["txtTelegram"]), "Telegram", $result);
        }

        //RicompenseProgetto
        $countRicompensa = count($_POST['txtRicompensaProgetto']);
        for ($i = 0; $i < $countRicompensa; $i++) {
            if (trim($_POST['txtRicompensaProgetto'][$i])!='') {
                INSERTRicompensa(trim($_POST['txtRicompensaProgetto'][$i]), $_POST['txtDescrizionePrezzo'][$i], $result);
            }
        }
    }
}


$date = new DateTime();
$today = $date->add(new DateInterval('P180D'))->format("Y-m-d");


$categorie = GETCategorie();
$title = "Crea un nuovo progetto";
include('header.php');
include('navbar.php');
?>

<div class="container">
    <h1 class="text-center">
        <?= $title ?>
    </h1>
    <form method="POST" action="" enctype="multipart/form-data">
        <div>
            <h5>Dati identificativi del progetto</h5>
            <div class="form-group">
                <label for="txtNomeProgetto">Nome Progetto</label>
                <input type="text" class="form-control" id="txtNomeProgetto" name="txtNomeProgetto" aria-describedby="txtNomeProgettoHelp">
                <small id="txtNomeProgettoHelp" class="form-text text-muted">Come si chiama il progetto?</small>
            </div>
            <div class="form-group">
                <label for="txtDescrizioneProgetto">Descrizione del progetto</label>
                <textarea class="form-control" id="txtDescrizioneProgetto" name="txtDescrizioneProgetto" aria-describedby="txtDescrizioneProgettoHelp"></textarea>
                <small id="txtDescrizioneProgettoHelp" class="form-text text-muted">Descrivi il progetto</small>
            </div>
            <div class="form-row">
                <div class="form-group col-md">
                    <label for="txtFineProgetto">Data fine del Progetto</label>
                    <input type="date" class="form-control" id="txtFineProgetto" name="txtFineProgetto" aria-describedby="txtFineProgettoHelp" value="<?= $today ?>">
                    <small id="txtFineProgettoHelp" class="form-text text-muted">Quando finisce la raccolta fondi?</small>
                </div>
                <div class="form-group col-md">
                    <label for="txtObiettivoProgetto">Obiettivo minimo</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">€</span>
                        </div>
                        <input type="number" class="form-control" id="txtObiettivoProgetto" name="txtObiettivoProgetto" aria-describedby="txtObiettivoProgettoHelp">
                        <div class="input-group-append">
                            <span class="input-group-text">.00</span>
                        </div>
                    </div>
                    <small id="txtObiettivoProgettoHelp" class="form-text text-muted">Quanti soldi hai bisogno per avviare il progetto?</small>
                </div>
            </div>
            <div class="form-group">
                <label for="txtCategoriaProgetto">Seleziona la categoria</label>
                <select class="form-control" id="txtCategoriaProgetto" name="txtCategoriaProgetto">
                    <?php foreach ($categorie as $row) { ?>
                        <option value="<?= $row["IDTag"] ?>"><?= $row["Ambito"] ?></option>
                    <?php } ?>
                </select>
            </div>
        </div>
        <div>
            <h5>Ricompense</h5>
            <div class="form-row">
                <div class="form-group col-md" id="multiPrice">
                    <label for="txtRicompensaProgetto">A partire da</label>
                    <div class="input-group mt-2">
                        <div class="input-group-prepend">
                            <span class="input-group-text">€</span>
                        </div>
                        <input type="number" class="form-control" name="txtRicompensaProgetto[]" min="0" value="0">
                        <div class="input-group-append">
                            <span class="input-group-text">.00</span>
                        </div>
                    </div>
                </div>
                <div class="form-group col-md" id="multiDesc">
                    <label for="txtDescrizionePrezzo">Descrizione</label>
                    <input type="text" class="form-control mt-2" name="txtDescrizionePrezzo[]">
                </div>
            </div>
            <button class="btn btn-info" name="submit" type="button" onclick="GeneraInput(1)">Aggiungi Riga</button>
        </div>
        <div>
            <h5>Carica gli allegati</h5>
            <div class="form-group">
                <label>Immagine del profilo:</label>
                <a class="btn btn-outline-light" id="bd-modal-profile-image" data-toggle="modal" data-target=".bd-modal-profile-image">Nessun file disponibile. Clicca qui per caricare</a>
                <div class="modal fade bd-modal-profile-image" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Immagine del progetto</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <label for="ImmagineProgetto">Allega l'immagine che caratterizza meglio il tuo progetto</label>
                                <input type="file" accept=".jpg, .jpeg, .png" size="2MB" class="form-control" id="ImmagineProgetto" name="ImmagineProgetto" aria-describedby="ImmagineProgettoHelp">
                                <small id="ImmagineProgettoHelp" class="form-text text-muted">Formati accettati: .jpeg, .jpg, .png<br>Dimensione massima consentita: 2 MB</small>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Annulla operazione</button>
                                <button type="button" data-dismiss="modal" class="btn btn-info btn-sm" onclick="UploadFile('#bd-modal-profile-image','#ImmagineProgetto');">Carica</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label>Altri allegati:</label>
                <a class="btn btn-outline-light" id="bd-modal-other" data-toggle="modal" data-target=".bd-modal-other">Nessun file disponibile. Clicca qui per caricare</a>
                <div class="modal fade bd-modal-other" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Altre risorse</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            </div>
                            <div class="modal-body">
                                <label for="RisorseProgetto">Descrivi il progetto allegando delle
                                    <span style="text-decoration: underline dashed" data-toggle="tooltip" data-placement="bottom" title="Ad esempio: immagini, manifesti, opuscoli, ecc.">risorse</span>
                                </label>
                                <input type="file" accept=".jpeg, .jpg, .png, .pdf, .docx, .pptx, .xlsl" size="5MB" class="form-control" id="RisorseProgetto" name="RisorseProgetto[]" aria-describedby="RisorseProgettoHelp" multiple>
                                <small id="RisorseProgettoHelp" class="form-text text-muted">Formati accettati: .jpeg, .jpg, .png, .pdf, .docx, .pptx, .xlsl<br>Dimensione massima consentita: 5 MB</small>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Annulla operazione</button>
                                <button type="button" data-dismiss="modal" class="btn btn-info btn-sm" onclick="UploadFiles('#RisorseProgetto','#bd-modal-other')">Carica</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div>
            <h5>Canali Social</h5>
            <div class="form-row">
                <div class="form-group col-md">
                    <label for="txtInstagram">Instagram</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fab fa-instagram"></i></span>
                        </div>
                        <input type="text" class="form-control" id="txtInstagram" name="txtInstagram" aria-describedby="txtInstagramHelp">
                    </div>
                    <small id="txtInstagramHelp" class="form-text text-muted">Instagram, di moda tra i giovani, ebbene perchè non usarlo per far partecipare anche loro</small>
                </div>
                <div class="form-group col-md">
                    <label for="txtFacebook">Facebook</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fab fa-facebook-f"></i></span>
                        </div>
                        <input type="text" class="form-control" id="txtFacebook" name="txtFacebook" aria-describedby="txtFacebookHelp">
                    </div>
                    <small id="txtFacebookHelp" class="form-text text-muted">Facebook, forse sorpassato ma perchè non sfruttarlo per rendere partecipe anche la popolazione meno aggiornata</small>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md">
                    <label for="txtTwitter">Twitter</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fab fa-twitter"></i></span>
                        </div>
                        <input type="text" class="form-control" id="txtTwitter" name="txtTwitter" aria-describedby="txtTwitterHelp">
                    </div>
                    <small id="txtTwitterHelp" class="form-text text-muted">Puoi usare twitter per pubblicare aggiornamenti di stato o più semplicemente per rigraziare chi ti ha donato</small>
                </div>
                <div class="form-group col-md">
                    <label for="txtTelegram">Telegram</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fab fa-telegram-plane"></i></span>
                        </div>
                        <input type="text" class="form-control" id="txtTelegram" name="txtTelegram" aria-describedby="txtTelegramHelp">
                    </div>
                    <small id="txtTelegramHelp" class="form-text text-muted">Hai Telegram? Benissimo molti utenti della nostra community lo usano costantemente</small>
                </div>
            </div>
        </div>
        <div class="form-row">
            <button class="btn btn-info" name="submit" type="submit" style="box-shadow: 0 2px 4px 0 rgba(0, 0, 0, 0.2), 0 2px 4px 0 rgba(0, 0, 0, 0.19);">Registrati</button>
            <a class="btn" onclick="location.href='../';">Torna alla home</a>
        </div>
    </form>
</div>
<?php
include('footer.php');
?>