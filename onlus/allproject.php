<?php

include('checksession.php');
require('../config/dalonlus.php');

$id = isset($_SESSION['ID']) ? $_SESSION['ID'] : header('Location: /public'); ;
if (isset($_POST['Elimina']) && $_POST['Elimina'] > 0) {
    DELETEProject($_POST['Elimina']);
    unset($_POST['Elimina']);
    header("allproject.php");
}

$page = isset($_GET['page']) ?  $_GET['page'] : 1;
$total = ceil(GETNumPagesProgetti($id) / 10);
$table = GETOnlusProgetti($id, $page);

$title = "Tutti i progetti";
include('header.php');
include('navbar.php');
?>

<div class="container">
    <div class="row my-3">
        <div class="col-12 col-sm-6 col-md-6">
            <h3 class="text-right"><?= $title ?></h3>
        </div>
        <div class="col-12 col-sm-6 col-md-6">
            <a type="button" class="btn btn-success mb-1 float-right" href="project.php">Nuovo Progetto</a>
        </div>
    </div>
    <table class="table table-responsive-md table-striped">
        <thead>
            <tr>
                <th>Nome Progetto</th>
                <th>Data Inizio</th>
                <th>Data Fine</th>
                <th>Obiettivo</th>
                <th>Donatori</th>
                <th>Operazioni</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($table as $row) { ?>
                <tr>
                    <th scope="row"><?= $row['Nome'] ?></th>
                    <td><?= $row['DataI'] ?></td>
                    <td><?= $row['DataF'] ?></td>
                    <td><?=isset($row['Totale'])?$row['Totale']:0 ?>/<?= $row['Obbiettivo'] ?></td>
                    <td><a class="nav-link" href="alldonatori.php?ID=<?= $row['IDProgetto'] ?>"><?= $row['Donatori'] ?></a></td>
                    <td>
                        <a type="button" class="btn btn-warning mb-1" href="project.php?ID=<?= $row['IDProgetto'] ?>">Modifica</a>
                        <br>
                        <form method="POST" action="">
                            <input type="hidden" name="Elimina" value="<?= $row['IDProgetto'] ?>">
                            <button type="button" class="btn btn-danger mt-1" onclick="confirm('Sei sicuro di voler eliminare questo elemento?') ? submit(): false">Elimina</button>
                        </form>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
    <nav>
        <ul class="pagination justify-content-center">
            <li class="page-item">
                <a class="page-link" href="?page=1" aria-label="Previous">
                    <span aria-hidden="true">&laquo;</span>
                    <span class="sr-only">Previous</span>
                </a>
            </li>
            <li class="page-item <?= $page <= 1 ? 'disabled' : '' ?>">
                <a class="page-link" href="<?= $page <= 1 ? '#' : "?page=". ($page - 1) ?>">Previous</a>
            </li>
            <li class="page-item <?= $page >= $total ? 'disabled' : '' ?>">
                <a class="page-link" href="<?= $page >= $total ? '#' : "?page=". ($page + 1) ?>">Next</a>
            </li>
            <li class="page-item">
                <a class="page-link" href="?page=<?= $total; ?>" aria-label="Next">
                    <span aria-hidden="true">&raquo;</span>
                    <span class="sr-only">Next</span>
                </a>
            </li>
        </ul>
    </nav>
</div>
<?php
include('footer.php');
?>