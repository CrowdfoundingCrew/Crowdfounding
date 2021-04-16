<?php
include('checksession.php');
require('../config/dalDonatori.php');
$id = isset($_SESSION['ID']) ? $_SESSION['ID'] : header('Location: /public'); ;

if (isset($_POST['submit'])) {
    if ($_POST['submit'] == 0) {
        if ($_POST["Password"] == $_POST["Password2"]) {
            $username=$_POST["Username"]==""?$_SESSION['Username']:$_POST["Username"];
            if (UPDATEDonatoriPrivate($_POST["Email"], $username, $_POST["Password"], $id)) {
                echo "<script>alert('Errore, Dati non validi')</script>";
            }
        }
    } else if ($_POST['submit'] == 1) {
        if (UPDATEDonatoriPublic($_POST['Indirizzo'],$_POST['Nome'],$_POST['Cognome'],$_POST['CF'],$id)) {
            echo "<script>alert('Errore, Dati non validi')</script>";
        }
    }
}

$array=GETUserProfile($id);

$title = "Modifica le impostazioni";
include('header.php');
include('navbar.php');
?>
<div class="container">
    <div class="col-md-12">
        <div class="card h-100">
            <div class="card-body px-5">
                <form method="POST">
                    <div class="row">
                        <div class="col-md-12 text-center">
                            <h6 class="mb-2 text-primary">Dati d'accesso</h6>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Username</label>
                                <input type="text" class="form-control" name="Username" value="<?=$array['Username']?>" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Email</label>
                                <input type="email" class="form-control" name="Email" value="<?=$array['E-mail']?>" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Nuova Password</label>
                                <input type="password" class="form-control" name="Password"required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Conferma la password</label>
                                <input type="password" class="form-control" name="Password2" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 text-center">
                            <div class="text-right">
                                <button type="button" class="btn btn-secondary">Annulla</button>
                                <button type="button" name="submit" value="0" class="btn btn-primary">Modifica</button>
                            </div>
                        </div>
                    </div>
                </form>
                <form method="POST">
                    <div class="row">
                        <div class="col-md-12 text-center">
                            <h6 class="mb-2 text-primary">Dati Personali</h6>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="Nome">Nome</label>
                                <input type="text" class="form-control" name="Nome" value="<?=$array['Nome']?>" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="Cognome">Cognome</label>
                                <input type="text" class="form-control" name="Cognome" value="<?=$array['Cognome']?>" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="CF">Codice Fiscale</label>
                                <input type="text" class="form-control" name="CF" value="<?=$array['CodiceFiscale']?>" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="Indirizzo">Indirizzo</label>
                                <input type="text" class="form-control" name="Indirizzo" value="<?=$array['Indirizzo']?>" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 text-center">
                            <div class="text-right">
                                <button type="button" class="btn btn-secondary">Annulla</button>
                                <button type="button" name="submit" value="1" class="btn btn-primary">Modifica</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php
include('footer.php');
?>