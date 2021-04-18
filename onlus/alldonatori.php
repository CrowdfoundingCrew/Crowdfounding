<?php

include('checksession.php');
require('../config/dalonlus.php');

$id = isset($_GET['ID']) ? $_GET['ID'] : header('Location: /public');

$page = isset($_GET['page']) ?  $_GET['page'] : 1;
$total = ceil(GETNumPagesDonatori($id) / 10);
$table = GETProgettoDonatori($id, $page);

$title = "Elenco donatori";
include('header.php');
include('navbar.php');
?>

<div class="container">
    <div class="row my-3">
        <div class="col-md-12">
            <h3 class="text-center"><?= $title ?></h3>
        </div>
    </div>
    <table class="table table-responsive-md table-striped">
        <thead>
            <tr>
                <th class="text-center">Identificativo</th>
                <th>Donatore</th>
                <th>Email</th>
                <th>Importo</th>
                <th>Data donazione</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($table as $row) { ?>
                <tr>
                    <th scope="row" class="text-center"><?= $row['IDUtente'] ?></th>
                    <td><?= $row['Donatore'] ?></td>
                    <td><?= $row['E-mail'] ?></td>
                    <td><?= $row['Importo'] ?></td>
                    <td><?= $row['Data'] ?></td>
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
        </ul>
    </nav>
</div>
<?php
include('footer.php');
?>