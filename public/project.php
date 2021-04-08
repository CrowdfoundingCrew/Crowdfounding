<?php
require '../config/publicDal.php';
session_start();
$title = "HomePage";
include('header.php');
include('navbar.php');
$data = FindProject($_GET['Idprj']);
?>
<link rel="stylesheet" href="../css/project.css">
<div class="container-fluid">
    <div class="row">
        <div class="col-md-4">
            <img alt="Logo" src="<?= $data[6] ?>" width="350px" height="350px" />
        </div>
        <div class="col-md-8">
            <h3>
                <?= $data[5] ?>
            </h3>
            <address>Indirizzo: <?= $data[9] ?></address>
            <abbr title="Email">Email: <?= $data[10] ?></abbr><br>
            <abbr title="Phone">Telefono: <?= $data[11] ?></abbr>
        </div>
    </div>
    <div class="row">
        <div class="col-md-8" id="content-column">
            <div class="row">
                <div class="col-md-12">
                    <h3 class="text-center">
                        <?= $data[0] ?>
                    </h3>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="progress">
                        <div class="progress-bar w-75">
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <p>
                        Obiettivo: <?= $data[2] ?> </br>
                        Inizio progetto: <?= $data[3] ?> </br>
                        Fine progetto: <?= $data[4] ?> </br>
                        <?= $data[1] ?> </br>
                        Tag: <?= $data[9] ?>
                    </p>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <?= $data[12] ?>
                </div>
            </div>
        </div>
        <div class="col-md-4" id="table-column">
            <table class="table">
                <thead>
                    <tr>
                        <th>
                            Descrizione
                        </th>
                        <th>
                            Importo minimo
                        </th>
                        <th>
                            Link
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <?= $data[13] ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php
include('footer.php');
?>