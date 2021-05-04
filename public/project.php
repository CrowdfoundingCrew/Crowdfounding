<?php
require '../config/dalpublic.php';
session_start();
$data = FindProject($_GET['Idprj']);
$title = "Progetto: " . $data[0];
include('header.php');
include('navbar.php');
?>
<link rel="stylesheet" href="../css/project.css">
<div class="container-fluid">
    <div class="row">
        <div class="col-md-4">
            <img alt="Logo" src="<?= isset($data[6]) ? $data[6] : 'https://wiki.dave.eu/images/4/47/Placeholder.png' ?>" width="150px" height="150px" />
        </div>
        <div class="col-md-8">
            <h2>
                <?= $data[10] ?>
            </h2>
            <div class="row">
                <div class="col-lg-6"><label class="font-weight-bolder"><i class="fas fa-map-marker-alt"></i>Indirizzo:</label> <?= $data[9] ?></div>
            </div>
            <div class="row">
                <div class="col-lg-6"><label class="font-weight-bolder"><i class="fas fa-envelope"></i>E-mail:</label> <?= isset($data[12]) ? $data[12] : 'Non disponibile' ?></div>
            </div>
            <div class="row">
                <div class="col-lg-6"><label class="font-weight-bolder"><i class="fas fa-phone-alt"></i>Telefono:</label> <?= isset($data[11]) ? $data[11] : 'Non disponibile' ?></div>
            </div>
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
                    <?= $data[16] ?>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <p>
                    <a href="../public/allprojects.php?cat=<?= $data[13] ?>" class="badge badge-secondary"><?= $data[7] ?></a></br>
                    <span class="font-weight-bold">Obiettivo:</span> <?= $data[2] ?> </br>
                    <span class="font-weight-bold">Inizio progetto:</span> <?= $data[3] ?> </br>
                    <span class="font-weight-bold">Fine progetto:</span> <?= $data[4] ?> </br>
                    <span class="font-weight-bold">Descrizione:</span></br>
                    <?= $data[1] ?>
                </p>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <?= $data[14] ?>
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
                <?= $data[15] ?>
                <form action="../donatori/paypal/paypal.html.php" method="GET">
                    <tr>
                        <td>Donazione a piacere</td>
                        <td><input class="form-control mr-sm-2" type="text" name="don" required></td>
                        <td>
                            <input type="hidden" name="prjname" id="prjname" class="form-control" value="<?= $data[0] ?>">
                            <input type="hidden" name="prjid" id="prjid" class="form-control" value="<?= $_GET['Idprj'] ?>">
                            <button type="submit" class='btn btn-primary btn-sm' href='?prjname=$Nome&don=$rmin&prjid=$id'>Dona ora!</button>
                        </td>
                    </tr>
                </form>
            </tbody>
        </table>
    </div>
</div>
</div>
<?php
include('footer.php');
?>