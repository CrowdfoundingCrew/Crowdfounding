<?php
//include ('checksession.php');
$id = 0;
if (isset($_GET['ID'])) {
    $id = $_GET['ID'];
} else if (isset($_SESSION['ID']) && $_SESSION['Tipo'] === 0) {
    $id = $_SESSION['ID'];
} else {
    $id = 0;
}

require('../config/dalDonatori.php');

$profile=GETUserProfile($id);
$project=GETUserProgetti($id);
$title = "Profilo di ".$profile['Username'];
include('header.php');
include('navbar.php');
?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/MaterialDesign-Webfont/5.3.45/css/materialdesignicons.css" integrity="sha256-NAxhqDvtY0l4xn+YVa6WjAcmd94NNfttjNsDmNatFVc=" crossorigin="anonymous" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.1/css/all.min.css" integrity="sha256-2XFplPlrFClt0bIdPgpz8H7ojnk10H69xRqd9+uTShA=" crossorigin="anonymous" />
<div class="container">
    <div class="row">
        <div class="col-lg-4 col-xl-4">
            <div class="card-box text-center">
                <h4 class="mb-0">@<?=$profile['Username']?></h4>
                <div class="text-left mt-3">
                    <p class="text-muted mb-2 font-13"><strong>Nome:</strong> <span class="ml-2"><?=$profile['Nome']?></span></p>
                    <p class="text-muted mb-2 font-13"><strong>Cognome:</strong><span class="ml-2"><?=$profile['Cognome']?></span></p>
                    <p class="text-muted mb-2 font-13"><strong>Email:</strong><span class="ml-2 "><?=$profile['E-mail']?></span></p>
                    <p class="text-muted mb-1 font-13"><strong>Indirizzo:</strong><span class="ml-2"><?=$profile['Indirizzo']?></span></p>
                    <p class="text-muted mb-1 font-13"><strong>Codice Fiscale:</strong><span class="ml-2"><?=$profile['CodiceFiscale']?></span></p>
                    <a href="setting.php" aria-expanded="false" class="nav-link"><i class="mdi mdi-settings-outline mr-1"></i>Modifica</a>
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
                            <?php foreach($project as $row){?>
                            <tr>
                                <td><a href="#<?=$row['IDProgetto']?>"><?=$row['Nome']?></a></td>
                                <td><?=$row['DataI']?></td>
                                <td><?=$row['DataF']?></td>
                                <td><?=$row['Importo']?></td>
                                <td><?=$row['Data']?></td>
                                <td><?=$row['Ricompensa']?></td>
                                <td><a href="/onlus/profile.php?ID=<?=$row['IDOnlus']?>"><?=$row['OnlusName']?></a></td>
                            </tr>
                            <?php }?>
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