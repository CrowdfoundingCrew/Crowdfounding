<?php
session_start();
require('../config/dalOnlus.php');

$id = 0;
if (isset($_GET['ID'])) {
    $id = $_GET['ID'];
} else if (isset($_SESSION['ID']) && $_SESSION['Tipo'] === 1) {
    $id = $_SESSION['ID'];
} else {
    $id = 0;
}

$page = isset($_GET['page']) ?  $_GET['page'] : 1;

$total = ceil(GETPages($id) / 10);
$onlus_array = GETOnlusProfile($id);
$progetti = GETOnlusProgetti($id, $page);
$title = $onlus_array['Denominazione'];
include('header.php');

if ($_SESSION['Tipo'] === 1) {
    include('navbar.php');
} else {
    include('/public/navbar.php');
}
?>
<div class="container-fluid">
    <div class="row pt-5 pb-5 profile-background-image">
        <div class="col-md-6">
            <img class="logo" src="https://cdn.wallpapersafari.com/77/90/056lrX.jpg" alt="" />
        </div>
        <div class="col-md-2">
            <div class="profile-head text-center text-md-left">
                <h1 class="font-weight-bolder"><?= $onlus_array['Denominazione'] ?></h1>
                <div class="row">
                    <div class="col-lg-6 font-weight-bolder"><label><i class="fas fa-map-marker-alt"></i>Indirizzo</label></div>
                    <div class="col-lg-6">
                        <p><?= $onlus_array['Indirizzo'] ?></p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6 font-weight-bolder"><label><i class="fas fa-envelope"></i>E-mail</label></div>
                    <div class="col-lg-6">
                        <p> <?= $onlus_array["E-mail"] ?></p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6 font-weight-bolder"><label><i class="fas fa-phone-alt"></i>Telefono</label></div>
                    <div class="col-lg-6">
                        <p><?= $onlus_array['Telefono'] ?></p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6 font-weight-bolder"><label>Codice Fiscale</label></div>
                    <div class="col-lg-6">
                        <p><?= $onlus_array['CodiceFiscale'] ?></p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6 font-weight-bolder"><label>Partita IVA</label></div>
                    <div class="col-lg-6">
                        <p><?= $onlus_array['PartitaIva'] ?></p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6 font-weight-bolder"><label>REA</label></div>
                    <div class="col-lg-6">
                        <p><?= $onlus_array['REA'] ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container mt-4">
        <div class="col-md-12 text-center">
            <h3>Progetti in corso</h3>
        </div>
        <?php
        foreach ($progetti as $row) {
        ?>
            <div class="row divide-project">
                <div class="row col-md-12">
                    <div class="col-lg-2 project-logo"><img src="https://www.layoutit.com/img/sports-q-c-140-140-3.jpg"></div>
                    <div class="col-lg-10">
                        <h2><?= $row['Nome'] ?></h2>
                        <a href="#" class="badge badge-primary"><?= $row['Ambito'] ?></a>
                        <div>
                            <p><?= substr($row['Descrizione'], 0, 100) ?>...<a class="ml-1" href="#">Prosegui con la lettura»</a></p>
                        </div>
                        <div><span class="font-weight-bold">Obiettivo:</span>
                            <p class="d-inline"><?= $row['Obbiettivo'] ?></p>
                        </div>
                        <div><span class="font-weight-bold">Donazioni:</span>
                            <p class="d-inline"><?= $row['Donatori'] ?></p>
                        </div>
                        <div><span class="font-weight-bold">Data termine:</span>
                            <p class="d-inline"><?= $row['DataF'] ?></p>
                        </div>
                        <button type="button" class="btn btn-success mt-1">Dona Ora!</button>
                    </div>
                </div>
            </div>
        <?php
        }
        ?>
        <nav>
            <ul class="pagination justify-content-center">
                <li class="page-item">
                    <a class="page-link" href="?ID=<?= $_GET['ID'] ?>&page=1" aria-label="Previous">
                        <span aria-hidden="true">&laquo;</span>
                        <span class="sr-only">Previous</span>
                    </a>
                </li>
                <li class="page-item <?= $page <= 1 ? 'disabled' : '' ?>">
                    <a class="page-link" href="<?= $page <= 1 ? '#' : "?ID=" . $_GET['ID'] . "&page=" . ($page - 1) ?>">Previous</a>
                </li>
                <li class="page-item <?= $page >= $total ? 'disabled' : '' ?>">
                    <a class="page-link" href="<?= $page >= $total ? '#' : "?ID=" . $_GET['ID'] . "&page=" . ($page + 1) ?>">Next</a>
                </li>
                <li class="page-item">
                    <a class="page-link" href="?ID=<?= $_GET['ID'] ?>&page=<?= $total; ?>" aria-label="Next">
                        <span aria-hidden="true">&raquo;</span>
                        <span class="sr-only">Next</span>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</div>
<?php
include('footer.php');
?>