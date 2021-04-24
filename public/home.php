<?php
session_start();
$title = "HomePage";
include('header.php');
include('navbar.php');
require '../config/sampleconnection.php';

function GetProjectRand($num)
{
    $mysqli = connectDB();
    $stmt = $mysqli->prepare("SELECT P.IDProgetto, P.Nome, P.Descrizione, (SELECT `Path` FROM `risorse` WHERE `Tipologia`=0 AND `IDProgetto`=P.IDProgetto) AS Logo FROM progetti AS P WHERE P.DataF>CURRENT_DATE() ORDER BY RAND() LIMIT ?");
    $stmt->bind_param('i', $num);
    $stmt->execute();
    $result = $stmt->get_result();
    $data = $result->fetch_all(MYSQLI_ASSOC);
    $result->free_result();
    $stmt->close();
    $mysqli->close();
    return $data;
}

function GetLastProject($num)
{
    $mysqli = connectDB();
    $stmt = $mysqli->prepare("SELECT P.IDProgetto, P.Nome, P.Descrizione, (SELECT `Path` FROM `risorse` WHERE `Tipologia`=0 AND `IDProgetto`=P.IDProgetto) AS Logo FROM progetti AS P WHERE P.DataF>CURRENT_DATE() ORDER BY P.DataI DESC, IDProgetto LIMIT ?");
    $stmt->bind_param('i', $num);
    $stmt->execute();
    $result = $stmt->get_result();
    $data = $result->fetch_all(MYSQLI_ASSOC);
    $result->free_result();
    $stmt->close();
    $mysqli->close();
    return $data;
}

function GetTopProject($num)
{
    $mysqli = connectDB();
    $stmt = $mysqli->prepare("SELECT P.IDProgetto, P.Nome, P.Descrizione, (SELECT `Path` FROM `risorse` WHERE `Tipologia`=0 AND `IDProgetto`=P.IDProgetto) AS Logo FROM progetti AS P INNER JOIN donazioni AS D ON P.IDProgetto=D.IDProgetto WHERE P.DataF>CURRENT_DATE() GROUP BY D.`IDProgetto` ORDER BY ROUND(SUM(`Importo`),2) DESC LIMIT ?");
    $stmt->bind_param('i', $num);
    $stmt->execute();
    $result = $stmt->get_result();
    $data = $result->fetch_all(MYSQLI_ASSOC);
    $result->free_result();
    $stmt->close();
    $mysqli->close();
    return $data;
}

function GetOnlusProfile($num)
{
    $mysqli = connectDB();
    $stmt = $mysqli->prepare("SELECT `IDUtente`, `E-mail`, Indirizzo, Denominazione, Immagine FROM utenti WHERE Tipo=1 ORDER BY RAND() LIMIT ?");
    $stmt->bind_param('i', $num);
    $stmt->execute();
    $result = $stmt->get_result();
    $data = $result->fetch_all(MYSQLI_ASSOC);
    $result->free_result();
    $stmt->close();
    $mysqli->close();
    return $data;
}

$slide = GetProjectRand(3);
$last = GetLastProject(3);
$top = GetTopProject(3);
$onlus = GetOnlusProfile(3);

?>
<style>
    .carousel-inner>.carousel-item>img {
        width: 100vw;
        height: 540px;
    }
</style>
<div id="myCarousel" class="carousel slide" data-ride="carousel">
    <ol class="carousel-indicators">
        <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
        <li data-target="#myCarousel" data-slide-to="1" class=""></li>
        <li data-target="#myCarousel" data-slide-to="2" class=""></li>
    </ol>
    <div class="carousel-inner">
        <?php
        $i = 0;
        foreach ($slide as $row) {
        ?>
            <?= ($i == 0) ? '<div class="carousel-item active">' : '<div class="carousel-item">' ?>
            <img class="d-block" src="<?= $row["Logo"] ?>" alt="Slide">
            <div class="carousel-caption d-none d-md-block text-dark">
                <h1><?= $row['Nome'] ?></h1>
                <p><?= substr($row['Descrizione'], 0, 100) ?>...</p>
                <p><a class="btn btn-lg btn-primary" href='./project.php?Idprj=<?= $row["IDProgetto"] ?>' role="button">Maggiori dettagli »</a></p>
            </div>
    </div>
<?php
            $i++;
        }
?>
</div>
<a class="carousel-control-prev" href="#myCarousel" role="button" data-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="sr-only">Previous</span>
</a>
<a class="carousel-control-next" href="#myCarousel" role="button" data-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="sr-only">Next</span>
</a>
</div>

<div class="container mt-5">
    <h2>Ultimi arrivati</h2>
    <hr class="featurette-divider">
    <div class="row mb-4">
        <?php
        foreach ($last as $row) {
        ?>
            <div class="col-lg-4">
                <img alt='Logo' src="<?= $row["Logo"] ?>" class='rounded-circle' widht='140px' height='140px' />
                <h3><?= $row['Nome'] ?></h3>
                <p><?= substr($row['Descrizione'], 0, 75) ?>...</p>
                <p><a class="btn btn-secondary" href='./project.php?Idprj=<?= $row["IDProgetto"] ?>' role="button">Maggiori dettagli »</a></p>
            </div>
        <?php
        }
        ?>
    </div>

    <h2>Top 5 progetti</h2>
    <hr class="featurette-divider">
    <div class="row mb-4">
        <?php
        foreach ($top as $row) {
        ?>
            <div class="col-lg-4">
                <img alt='Logo' src="<?= $row["Logo"] ?>" class='rounded-circle' widht='140px' height='140px' />
                <h3><?= $row['Nome'] ?></h3>
                <p><?= substr($row['Descrizione'], 0, 75) ?>...</p>
                <p><a class="btn btn-secondary" href='./project.php?Idprj=<?= $row["IDProgetto"] ?>' role="button">maggiori dettagli »</a></p>
            </div>
        <?php
        }
        ?>
    </div>

    <h2>Visualizza i progetti di queste onlus</h2>
    <hr class="featurette-divider">
    <div class="row mb-4">
        <?php
        foreach ($onlus as $row) {
        ?>
            <div class="col-lg-4">
                <img alt='Logo' src="<?= $row["Immagine"] ?>" class='rounded-circle' widht='140px' height='140px' />
                <h3><?= $row['Denominazione'] ?></h3>
                <p><label><i class="fas fa-envelope"></i>E-mail:</label> <?= $row['E-mail'] ?></p>
                <p><label><i class="fas fa-map-marker-alt"></i>Indirizzo:</label> <?= $row['Indirizzo'] ?></p>
                <p><a class="btn btn-secondary" href='/onlus/profile.php?ID=<?= $row['IDUtente'] ?>' role="button">Maggiori dettagli »</a></p>
            </div>
        <?php
        }
        ?>
    </div>
</div>
<?php
include('footer.php');
?>