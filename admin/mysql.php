<?php
include '../config/sampleconnection.php';

function Onlus($no_of_records_per_page, $offset, $search)
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


    $sql = "SELECT IDUtente, Denominazione, `E-mail`, Indirizzo, PartitaIva, REA, COUNT(progetti.IDProgetto) AS Progetti
            FROM utenti INNER JOIN progetti ON utenti.IDUtente = progetti.IDOnlus
            WHERE Tipo = 1 AND Denominazione LIKE ? 
            GROUP BY IDUtente
            ORDER BY COUNT(progetti.IDProgetto) DESC 
            LIMIT $offset, $no_of_records_per_page";

    $result_data = $conn->prepare($sql);
    $result_data->bind_param("s", $search);
    $result_data->execute();
    $result_data->bind_result($IDUtente, $nomeonlus, $Email, $Indirizzo, $IVA, $REA, $NProgetti);
    $result = "";

    while ($result_data->fetch()) {
        $descrizioneonlus = $Email . " - " . $Indirizzo . " - " . $IVA . " - " . $REA;
        $paginaonlus = "/onlus/profile.php?ID=" . $IDUtente;
        if ($result == "") {
            $result = $result . "<div class='row pt-3'>
            <div class='col-md-12'>
                <h3>
                    $nomeonlus - Progetti: $NProgetti
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
        } else {
            $result = $result . "<div class='row border-top border-primary pt-3'>
            <div class='col-md-12'>
                <h3>
                    $nomeonlus - Progetti: $NProgetti
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
        }

        $conn2 = connectDB();

        $sqlprogetti = "SELECT IDProgetto, Nome, Descrizione, DataI, DataF, Obbiettivo FROM progetti WHERE IDOnlus = " . $IDUtente . " LIMIT 3";
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
            while ($donazione = $donazioni->fetch_assoc()) {
                $totdona = $totdona + $donazione["Importo"];
            }

            $barprogetto = floor($totdona / $progetto["Obbiettivo"] * 100);

            if ($barprogetto < 30) {
                $coloreprogetto = "danger";
            } else if ($barprogetto < 50) {
                $coloreprogetto = "warning";
            } else if ($barprogetto < 80) {
                $coloreprogetto = "info";
            } else if ($barprogetto < 100) {
                $coloreprogetto = "primary";
            } else {
                $coloreprogetto = "success";
            }

            if ($immagine)
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

function Donatori($no_of_records_per_page, $offset, $search)
{
    $conn = connectDB();

    $total_pages_sql = "SELECT COUNT(*) AS Pagine FROM utenti WHERE Tipo = b'00' AND Username LIKE ?";
    $countrows = $conn->prepare($total_pages_sql);
    $search = $search . "%";
    $countrows->bind_param("s", $search);
    $countrows->execute();
    $countrows->bind_result($total_rows);
    $countrows->fetch();
    $total_pages = ceil($total_rows / $no_of_records_per_page);
    $countrows->close();


    $sql = "SELECT utenti.IDUtente, Username, Nome, Cognome, utenti.`E-mail`, Indirizzo, ROUND(SUM(Importo),2) AS Donazioni FROM utenti LEFT JOIN donazioni ON utenti.IDUtente = donazioni.IDUtente WHERE Tipo = 0 AND Username LIKE ? GROUP BY utenti.IDUtente LIMIT $offset, $no_of_records_per_page";
    $result_data = $conn->prepare($sql);
    $result_data->bind_param("s", $search);
    $result_data->execute();
    $result_data->bind_result($IDUtente, $Username, $Nome, $Cognome, $Email, $Indirizzo, $Donazioni);
    $result = "<div class='container-fluid'>";
    $count = 0;

    while ($result_data->fetch()) {
        if ($result != "<div class='container-fluid'>") {
            if ($count % 3 == 0) {
                $result = $result . "<div class='row border-top border-primary pt-3'>";
            }
        }else{
            if ($count % 3 == 0) {
                $result = $result . "<div class='row pt-3'>";
            }
        }
        if ($Donazioni == NULL) {
            $Donazioni = 0;
        }
        $linkuser = "/donatori/profile.php?ID=" . $IDUtente;

        $result = $result . "<div class='col-md-4'>
			                    <p>
                                    <i class=\"far fa-user\"></i><strong>$Username: $Cognome $Nome</strong><br>
                                    <i class=\"far fa-envelope\"></i>E-mail: $Email<br>
                                    <i class=\"fas fa-map-marker-alt\"></i>Indirizzo: $Indirizzo<br>
                                    Totale delle donazioni: $Donazioni<br>
                                    <a class=\"ml-1\" href='$linkuser'>Maggiori dettagli»</a>
                                </p>
		                     </div>";

        if ($count % 3 == 2) {
            $result = $result . "</div>";
        }
        $count++;
    }

    $result = $result . "</div>";
    $conn->close();
    return [$result, $total_pages];
}

function NewAdmin($Nome, $Cognome, $Username, $Email, $Password)
{
    $conn = connectDB();
    $pass = password_hash($Password, PASSWORD_DEFAULT);
    $stmt = $conn->prepare("INSERT INTO utenti(Username, Password, `E-mail`, Tipo, Nome, Cognome) VALUES (?,?,?,b'10',?,?)");
    $stmt->bind_param('sssss', $Username, $pass, $Email, $Nome, $Cognome);
    $stmt->execute();
    echo $stmt->error;
    $stmt->close();
    $conn->close();

    return;
}
