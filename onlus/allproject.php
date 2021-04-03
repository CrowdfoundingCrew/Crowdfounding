<?php

include ('checksession.php');
require('../config/dalOnlus.php');
//define('SITE_ROOT', __DIR__);

$id = isset($_SESSION['ID']) ? $_SESSION['ID'] : 0;
if (isset($_POST['Elimina']) && $_POST['Elimina'] > 0) {
    DELETEProject($_POST['Elimina']);
    header("allproject.php");
}

$table = GETOnlusProgetti($id, 0);
$title = "Tutti i progetti";
include('header.php');
include('navbar.php');
?>

<div class="container">
    <div class="row my-3">
        <div class="col-12 col-sm-6 col-md-6">
            <h3 class="text-right">Tutti i progetti</h3>
        </div>
        <div class="col-12 col-sm-6 col-md-6">
            <a type="button" class="btn btn-success mb-1 float-right" href="project.php">Nuovo Progetto</a>
        </div>
    </div>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Nome Progetto</th>
                <th>Data Inizio</th>
                <th>Data Fine</th>
                <th>Obiettivo</th>
                <th>Operazioni</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($table as $row) { ?>
                <tr>
                    <th scope="row"><?= $row['Nome'] ?></th>
                    <td><?= $row['DataI'] ?></td>
                    <td><?= $row['DataF'] ?></td>
                    <td><?= $row['Obbiettivo'] ?></td>
                    <td>
                        <a type="button" class="btn btn-warning mb-1" href="project.php?ID=<?= $row['IDProgetto'] ?>">Modifica</a>
                        <br>
                        <form method="POST" action="">
                            <button type="submit" name="Elimina" class="btn btn-danger mt-1" value="<?= $row['IDProgetto'] ?>">Elimina</button>
                        </form>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>
<?php
include('footer.php');
?>