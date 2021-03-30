<?php
include '../config/sampleconnection.php';

function Pagination($no_of_records_per_page, $offset, $search)
{
    $conn = connectDB();

   
    $total_pages_sql = "SELECT COUNT(*) AS Pagine FROM utenti WHERE Tipo = b'01' AND Denominazione LIKE ?";
    $countrows = $conn->prepare($total_pages_sql);
    $search = $search . "%";
    $countrows->bind_param("s", $search);
    $countrows->execute();
    $countrows->bind_result($total_rows);
    $countrows->fetch();
    $total_pages = ceil($total_rows / $no_of_records_per_page);
    $countrows->close();


    $sql = "SELECT IDUtente, Denominazione, `E-mail`, Indirizzo, PartitaIva, REA FROM utenti WHERE Tipo = 1 AND Denominazione LIKE ? LIMIT $offset, $no_of_records_per_page";
    $result_data = $conn->prepare($sql);
    $result_data->bind_param("s", $search);
    $result_data->execute();
    $result_data->bind_result($IDUtente, $nomeonlus, $Email, $Indirizzo, $IVA, $REA);
    $result = "";

    while ($result_data->fetch()) {
        $descrizioneonlus = $Email . " - " . $Indirizzo . " - " . $IVA . " - " . $REA;
        $paginaonlus = "?Onlus=" . $IDUtente;
        $result = $result . "<div class='row'>
            <div class='col-md-12'>
                <h3>
                    $nomeonlus
                </h3>
                <p>
                    $descrizioneonlus
                </p>
                <p>
                    <a class='btn' href='$paginaonlus'>View details »</a>
                </p>
            </div>
            </div>" .
            "<div class='row'>";

        $conn2 = connectDB();

        $sqlprogetti = "SELECT IDProgetto, Nome, Descrizione, DataI, DataF, Obbiettivo FROM progetti WHERE IDOnlus = " . $IDUtente. " LIMIT 3";
        $progetti = $conn2->query($sqlprogetti);
        while ($progetto = $progetti->fetch_assoc()) {
            $nomeprogetto = $progetto['Nome'];
            $descrizioneprogetto = str_split($progetto['Descrizione'], 140)[0] . "...";
            $datiprogetto = $progetto['DataI'] . " - " . $progetto['DataF'] . " Obbiettivo: " . $progetto['Obbiettivo'] . "€";

            $sqlimmagine = "SELECT Path FROM risorse WHERE IDProgetto =" . $progetto["IDProgetto"] . " AND Tipologia = 0 LIMIT 1";
            $immagine = $conn2->query($sqlimmagine)->fetch_assoc();

            $sqldonazioni = "SELECT Importo FROM donazioni WHERE IDProgetto =" . $progetto["IDProgetto"] . " AND Status = 'Ok'";
            $donazioni = $conn2->query($sqldonazioni);
            $totdona = 0;
            while($donazione = $donazioni->fetch_assoc()){
                $totdona = $totdona + $donazione["Importo"];
            }

            $barprogetto = floor($totdona / $progetto["Obbiettivo"] * 100);

            if($barprogetto < 30){
                $coloreprogetto = "danger";
            } else if($barprogetto <50){
                $coloreprogetto = "warning";
            } else if ($barprogetto < 80){
                $coloreprogetto = "info";
            } else if ($barprogetto < 100){
                $coloreprogetto = "primary";
            } else {
                $coloreprogetto = "success";
            }

            if($immagine)
                $immagineprogetto = $immagine["Path"];
            else
                $immagineprogetto = "../assets/img/placeholder.png";

            $result = $result .
                "<div class='col-md-4'>
                    <img class='rounded mx-auto d-block' alt='img del progetto' src='$immagineprogetto' style='width: 150px;'>
                    <div class='progress mt-2'>
                        <div class='progress-bar progress-bar-animated progress-bar-striped bg-$coloreprogetto' style='width: $barprogetto%'>
                        </div>
                    </div>
                    <address><strong>$nomeprogetto</strong><br>$datiprogetto </address>
                    <blockquote class='blockquote'>
                        <p class='mb-0'>$descrizioneprogetto</p>
                    </blockquote>
                </div>";
        }
        $result = $result . "</div>";
        $conn2->close();
    }

    $conn->close();
    return [$result, $total_pages];
}
