<?php
session_start();

$id = 0;
if (isset($_GET['ID']) and isset($_SESSION['Tipo']) and $_SESSION['Tipo'] === 0) {
    $id = $_GET['ID'];
} else if (isset($_SESSION['ID']) && $_SESSION['Tipo'] === 0) {
    $id = $_SESSION['ID'];
} else {
    header('Location: /public');
}

require('../config/daldonatori.php');

$profile = GETUserProfile($id);
$project = GETUserProgetti($id);
$title = "Profilo di " . $profile['Username'];
include('header.php');

if ($_SESSION['Tipo'] === 0) {
    include('navbar.php');
} else {
    include('../public/navbar.php');
}
?>
<div class="container">
    <div class="row">
        <div class="col-lg-4 col-xl-4">
            <div class="card-box text-center mt-4">
                <h4 class="mb-0">@<?= $profile['Username'] ?></h4>
                <div class="text-center text-md-left mt-3">
                    <p class="text-muted mb-2 font-13"><strong>Nome:</strong> <span class="ml-2"><?= $profile['Nome'] ?></span></p>
                    <p class="text-muted mb-2 font-13"><strong>Cognome:</strong><span class="ml-2"><?= $profile['Cognome'] ?></span></p>
                    <p class="text-muted mb-2 font-13"><strong>Email:</strong><span class="ml-2 "><?= $profile['E-mail'] ?></span></p>
                    <p class="text-muted mb-1 font-13"><strong>Indirizzo:</strong><span class="ml-2"><?= $profile['Indirizzo'] ?></span></p>
                    <p class="text-muted mb-1 font-13"><strong>Codice Fiscale:</strong><span class="ml-2"><?= $profile['CodiceFiscale'] ?></span></p>
                    <a href="./setting.php" aria-expanded="false" class="nav-link"><i class="mdi mdi-settings-outline mr-1"></i>Modifica le informazioni dell'account</a>
                    <a href="#" onclick="confirm('Sei sicuro di voler eliminare l\'account?') ? window.location.href = 'delete.php' : false" aria-expanded="false" class="nav-link"><i class="mdi mdi-settings-outline mr-1"></i>Elimina l'account</a>
                </div>
            </div>
        </div>

        <div class="col-lg-8 col-xl-8">
            <div>
                <h5 class="mb-3 mt-4 text-uppercase"><i class="mdi mdi-cards-variant mr-1"></i>Progetti</h5>
                <div class="table-responsive-md">
                    <table class="table table-borderless mb-0">
                        <thead class="thead-light">
                            <tr>
                                <th>Nome progetto</th>
                                <th>Data d'inizio</th>
                                <th>Data di fine</th>
                                <th>Donazione Effettuata</th>
                                <th>Data del pagamento</th>
                                <th>Ricompensa</th>
                                <th>Onlus</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($project as $row) { ?>
                                <tr>
                                    <td><a href="#<?= $row['IDProgetto'] ?>"><?= $row['Nome'] ?></a></td>
                                    <td><?= $row['DataI'] ?></td>
                                    <td><?= $row['DataF'] ?></td>
                                    <td><?= $row['Importo'] ?></td>
                                    <td><?= $row['Data'] ?></td>
                                    <td><?= $row['Ricompensa']==NULL? 'Non disponibile': $row['Ricompensa']?></td>
                                    <td><a href="/onlus/profile.php?ID=<?= $row['IDOnlus'] ?>"><?= $row['OnlusName'] ?></a></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
include('footer.php');
?>