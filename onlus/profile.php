<?php
session_start();
$id=isset($_GET['ID'])?intval($_GET['ID']):0;
$page=isset($_GET['page'])?intval($_GET['page']):0;

require('../config/dalOnlus.php');
$onlus_array=GETOnlusProfile($id);
$progetti=GETOnlusProgetti($id,$page);
$title=$onlus_array['Denominazione'];
include('header.php');
include('navbar.php');
?>
    <div class="container-fluid">
        <div class="profile-detail d-flex flex-column text-center">
            <img class="profile-background-image"/>
            <img align="left" class="logo" src="https://cdn.wallpapersafari.com/77/90/056lrX.jpg"/>
            <h1 class="font-weight-bolder"><?=$onlus_array['Denominazione']?></h1>
            <address>Indirizzo: <?=$onlus_array['Indirizzo']?></address>
            <abbr title="Email">Email <?=$onlus_array["E-mail"]?></abbr> 
            <abbr title="Phone">Telefono: <?=$onlus_array['Telefono']?></abbr> 
            <address>Partita IVA: <?=$onlus_array['PartitaIva']?></address>
        </div>

        <div class="container mt-4">
            <div class="col-md-12 text-center">
                <h3>Progetti in corso</h3>
            </div>
            <?php
            foreach($progetti as $row){
                ?>
            <div class="row divide-project">
                <div class="row col-md-12">
                    <div class="col-lg-2 project-logo"><img src="https://www.layoutit.com/img/sports-q-c-140-140-3.jpg"></div>
                    <div class="col-lg-10">
                        <h2><?=$row['Nome']?></h2>
                        <div>
                            <p><?=$row['Descrizione']?>...<a class="ml-1" href="#">Prosegui con la lettura»</a></p>
                        </div>
                        <div><span class="font-weight-bold">Obiettivo:</span>
                            <p class="d-inline"><?=$row['Obbiettivo']?></p>
                        </div>
                        <!-- <div><span class="font-weight-bold">Donazioni raggiunte:</span>
                            <p class="d-inline"><?=$row['']?></p>
                        </div> -->
                        <div><span class="font-weight-bold">Data termine:</span>
                            <p class="d-inline"><?=$row['DataF']?></p>
                        </div>
                        <button type="button" class="btn btn-success mt-1">Dona Ora!</button>
                    </div>
                </div>
            </div>
            <?php
            }
                ?>
        </div>
    </div>
    <?php
    include('footer.php');
?>