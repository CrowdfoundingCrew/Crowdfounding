<?php
session_start();
require('../config/dalonlus.php');

$id = 0;
if (isset($_GET['ID'])) {
    $id = $_GET['ID'];
} else if (isset($_SESSION['ID']) && $_SESSION['Tipo'] === 1) {
    $id = $_SESSION['ID'];
} else {
    header('Location: /public'); 
}

$page = isset($_GET['page']) ?  $_GET['page'] : 1;

$total = ceil(GETNumPagesProgetti($id) / 10);
$onlus_array = GETOnlusProfile($id);
$progetti = GETOnlusProgetti($id, $page);
$title = $onlus_array['Denominazione'];
include('header.php');

if (isset($_SESSION['ID']) && $_SESSION['Tipo'] === 1) {
    include('navbar.php');
} else {
    include('../public/navbar.php');
}
?>
<div class="container-fluid">
    <div class="row pt-5 pb-5 profile-background-image">
        <div class="col-md-6">
            <img class="logo" src="<?= $onlus_array['Immagine'] ?>" alt="" height="150px" width="150px"/>
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
            <h2>Progetti in corso</h2>
        </div>
        <?php
        foreach ($progetti as $row) {
        ?>
            <div class="row divide-project">
                <div class="row col-md-12">
                    <div class="col-lg-2 project-logo"><img src="<?= $row['Logo'] ?>" alt="Foto profilo progetto"></div>
                    <div class="col-lg-10">
                        <h3><?= $row['Nome'] ?></h3>
                        <a href="#" class="badge badge-primary"><?= $row['Ambito'] ?></a>
                        <div>
                            <p><?= substr($row['Descrizione'], 0, 100) ?>...<a class="ml-1" href="/public/project.php?Idprj=<?=$row['IDProgetto']?>">Prosegui con la lettura»</a></p>
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
            <?php if(isset($_GET['ID'])){ ?>
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
                <?php }else{ ?>
                    <li class="page-item">
                    <a class="page-link" href="?page=1" aria-label="Previous">
                        <span aria-hidden="true">&laquo;</span>
                        <span class="sr-only">Previous</span>
                    </a>
                </li>
                <li class="page-item <?= $page <= 1 ? 'disabled' : '' ?>">
                    <a class="page-link" href="<?= $page <= 1 ? '#' : "?page=" . ($page - 1) ?>">Previous</a>
                </li>
                <li class="page-item <?= $page >= $total ? 'disabled' : '' ?>">
                    <a class="page-link" href="<?= $page >= $total ? '#' : "?page=" . ($page + 1) ?>">Next</a>
                </li>
                <li class="page-item">
                    <a class="page-link" href="?page=<?= $total; ?>" aria-label="Next">
                        <span aria-hidden="true">&raquo;</span>
                        <span class="sr-only">Next</span>
                    </a>
                </li>
                    <?php } ?>
            </ul>
        </nav>
    </div>
</div>
<?php
include('footer.php');
?>