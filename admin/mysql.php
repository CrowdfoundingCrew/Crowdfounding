<?php
include '../config/config.php';

function Pagination($no_of_records_per_page, $offset)
{
    $conf = GetDBConfig();
    $conn = new mysqli($conf['hostname'], $conf['username'], $conf['password'], $conf['dbname']);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

   
    $total_pages_sql = "SELECT COUNT(*) AS Pagine FROM utenti WHERE Tipo = b'01'";
    $countrows = $conn->query($total_pages_sql);
    $total_rows = $countrows->fetch_assoc();
    $total_pages = ceil($total_rows["Pagine"] / $no_of_records_per_page);


    $sql = "SELECT IDUtente, Denominazione, `E-mail`, Indirizzo, CodiceFiscale FROM utenti WHERE Tipo = 1 LIMIT $offset, $no_of_records_per_page";
    $result_data = $conn->query($sql);
    $result = "";

    while ($row = $result_data->fetch_assoc()) {
        $nomeonlus = $row['Denominazione'];
        $descrizioneonlus = $row['E-mail'] . " " . $row["Indirizzo"] . " " . $row['CodiceFiscale'];
        $paginaonlus = "?Onlus=" . $row['IDUtente'];
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
        $sqlprogetti = "SELECT Nome, Descrizione, DataI, DataF, Obbiettivo FROM progetti WHERE IDOnlus = " . $row['IDUtente'] . " LIMIT 3";
        $progetti = $conn->query($sqlprogetti);
        while ($progetto = $progetti->fetch_assoc()) {
            $nomeprogetto = $progetto['Nome'];
            $descrizioneprogetto = $progetto['Descrizione'];
            $datiprogetto = $progetto['DataI'] . " - " . $progetto['DataF'] . " Obbiettivo: " . $progetto['Obbiettivo'] . "€";
            $coloreprogetto = "info";
            $barprogetto = 68;
            $immagineprogetto = "https://www.layoutit.com/img/sports-q-c-140-140-3.jpg";
            $result = $result .
                "<div class='col-md-4'>
                    <img alt='Bootstrap Image Preview' src='$immagineprogetto'>
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
    }

    $conn->close();
    return [$result, $total_pages];
}
