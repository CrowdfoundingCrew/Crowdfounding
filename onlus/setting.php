<?php
include('checksession.php');
require('../config/dalonlus.php');
define('SITE_ROOT', __DIR__);

$id = isset($_SESSION['ID']) ? $_SESSION['ID'] : header('Location: /public'); ;
$array = GETOnlusProfile($id);

if (isset($_POST['submit'])) {
    if ($_POST['submit'] == 0) {
        if ($_POST["Password"] == $_POST["Password2"]) {
            if (UPDATEOnlusPrivate($_POST["Email"], $_POST["Username"], $_POST["Password"], $id)) {
                echo "<script>alert('Errore')</script>";
            }
        }
    } else if ($_POST['submit'] == 1) {
        if (UPLOAD_ERR_OK === $_FILES['LOGO']['error']) {
            if ($_FILES['LOGO']['size'] > 0) {
                $uploadDirPhoto = SITE_ROOT.'\assets\avatar';
                $fileNamePhoto = $id . "_" . strval(date('Y-m-d'))."_".strval(date('H:i:s')).".jpg";
                move_uploaded_file($_FILES['LOGO']['tmp_name'], $uploadDirPhoto . DIRECTORY_SEPARATOR . $fileNamePhoto);
                $profile_path = $uploadDirPhoto . DIRECTORY_SEPARATOR . $fileNamePhoto;
                unlink($array['Immagine']);
                if (UPDATEOnlusProfile($_POST["CF"], $_POST["Indirizzo"], $_POST["Denominazione"], $_POST["Telefono"], $_POST["Piva"], $_POST["REA"], $profile_path, $id)) {
                    echo "<script>alert('Errore')</script>";
                }
            } else {
                if (UPDATEOnlusProfile($_POST["CF"], $_POST["Indirizzo"], $_POST["Denominazione"], $_POST["Telefono"], $_POST["Piva"], $_POST["REA"], $array['Immagine'], $id)) {
                    echo "<script>alert('Errore')</script>";
                }
            }
        }
    }
}

$title = "Modifica profilo";
include('header.php');
include('navbar.php');
?>
<div class="container">
    <form class="mx-5 px-5" method="POST">
        <div class="my-5">
            <h5>Dati d'accesso</h5>
            <div class="form-group">
                <label>Username</label>
                <input type="text" class="form-control" name="Username">
            </div>
            <div class="form-group">
                <label>Email</label>
                <input type="text" class="form-control" value="<?= $array['E-mail'] ?>" name="Email">
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" class="form-control" name="Password">
            </div>
            <div class="form-group">
                <label>Conferma la password</label>
                <input type="password" class="form-control" name="Password2">
            </div>
            <div class="my-3">
                <button class="btn btn-info" name="submit" type="submit" style="box-shadow: 0 2px 4px 0 rgba(0, 0, 0, 0.2), 0 2px 4px 0 rgba(0, 0, 0, 0.19);" value="0">Salva</button>
            </div>
        </div>
    </form>
    <form class="mx-5 px-5" method="POST" enctype="multipart/form-data">
        <div>
            <h5>Dati Anagrafici</h5>
            <div class="form-group">
                <label>Denominazione</label>
                <input type="text" class="form-control" value="<?= $array['Denominazione'] ?>" name="Denominazione">
            </div>
            <div class="form-group">
                <label>Indirizzo</label>
                <input type="text" class="form-control" value="<?= $array['Indirizzo'] ?>" name="Indirizzo">
            </div>
            <div class="form-group">
                <label>Telefono</label>
                <input type="number" class="form-control" value="<?= $array['Telefono'] ?>" name="Telefono">
            </div>
            <div class="form-group">
                <label>Partita IVA</label>
                <input type="text" class="form-control" value="<?= $array['PartitaIva'] ?>" name="Piva">
            </div>
            <div class="form-group">
                <label>Codice Fiscale</label>
                <input type="text" class="form-control" value="<?= $array['CodiceFiscale'] ?>" name="CF">
            </div>
            <div class="form-group">
                <label>REA</label>
                <input type="text" class="form-control" value="<?= $array['REA'] ?>" name="REA">
            </div>
            <div class="form-group">
                <label>Foto</label>
                <input type="file" class="form-control" name="LOGO">
            </div>
        </div>
        <div class="my-3">
            <button class="btn btn-info" name="submit" type="submit" style="box-shadow: 0 2px 4px 0 rgba(0, 0, 0, 0.2), 0 2px 4px 0 rgba(0, 0, 0, 0.19);" value="1">Salva</button>
        </div>
    </form>
</div>
<?php
include('footer.php');
?>