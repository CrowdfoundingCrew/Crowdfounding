<?php
require('config.php');

function connectDB()
{
    $cfg = GetDBConfig();
    $conn = mysqli_connect($cfg['hostname'], $cfg['username'], $cfg['password'], $cfg['dbname']);
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
    return $conn;
}

function InsertDonator($mail, $usr, $psw, $name, $surn, $cdf, $addr)
{
    $conn = connectDB();
    $pass = password_hash($psw, PASSWORD_DEFAULT);
    $stmt = $conn->prepare('INSERT INTO utenti(Username, Password, `E-mail`, Indirizzo, Tipo, Nome, Cognome, CodiceFiscale) VALUES (?,?,?,?,?,?,?,?)');
    $value = 0;
    $stmt->bind_param('ssssisss', $usr, $pass, $mail, $addr, $value, $name, $surn, $cdf);
    $stmt->execute();
    $stmt->close();
    $conn->close();
}

function InsertOnlus($mail, $usr, $psw, $cdf, $addr, $den, $cell, $piva, $rea)
{
    $conn = connectDB();
    $pass = password_hash($psw, PASSWORD_DEFAULT);
    $stmt = $conn->prepare('INSERT INTO utenti(Username, Password, `E-mail`, Indirizzo, Tipo, CodiceFiscale, Denominazione, Telefono, PartitaIva, REA) VALUES (?,?,?,?,?,?,?,?,?,?)');
    $value = 1;
    $stmt->bind_param('ssssisssss', $usr, $pass, $mail, $addr, $value, $cdf, $den, $cell, $piva, $rea);
    $stmt->execute();
    $result = $stmt->get_result();
    if (!$result)
        $result = $stmt->insert_id;
    $stmt->close();
    $conn->close();
    return $result;
}

function InsertOnlusWithLogo($id, $path)
{
    $conn = connectDB();
    $stmt = $conn->prepare('UPDATE `utenti` SET `Immagine`= ? WHERE `IDUtente` = ? ');
    $stmt->bind_param('si', $path, $id);
    $stmt->execute();
    $stmt->close();
    $conn->close();
}

function FindUser($Username)
{
    $conn = connectDB();
    $stmt = $conn->prepare('SELECT `IDUtente`,`Password`,`Tipo` FROM `utenti` WHERE `Username` = ?');
    $stmt->bind_param('s', $Username);
    $stmt->execute();
    $stmt->bind_result($id, $pass, $tipo);
    $stmt->fetch();
    $data = array($id, $pass, $tipo);
    $stmt->close();
    $conn->close();
    return $data;
}
function FindProject($id)
{
    $conn = connectDB();
    $stmt = $conn->prepare('SELECT progetti.Nome, progetti.Descrizione, progetti.Obbiettivo, progetti.DataI, progetti.DataF, utenti.Username, utenti.Immagine, tag.Ambito, (SELECT `Path` FROM `risorse` WHERE `Tipologia`=0 AND `IDProgetto`=progetti.IDProgetto) AS Path, utenti.Indirizzo, utenti.Denominazione, utenti.Telefono, `utenti`.`E-mail`, tag.IDTag  FROM progetti INNER JOIN utenti ON progetti.IDOnlus = utenti.IDUtente INNER JOIN tag ON progetti.IDTag= tag.IDTag WHERE progetti.IDProgetto = ?');
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $stmt->bind_result($Nome, $Descrizione, $Obbiettivo, $DataI, $DataF, $Username, $Immagine, $Ambito, $path, $addr, $den, $tel, $mail,$tag);
    $stmt->fetch();
    $data = array($Nome, $Descrizione, $Obbiettivo, $DataI, $DataF, $Username, $Immagine, $Ambito, $path, $addr, $den, $tel, $mail,$tag);
    $stmt->close();

    $stmt = $conn->prepare('SELECT `Path` FROM `risorse` INNER JOIN progetti ON risorse.IDProgetto=progetti.IDProgetto WHERE progetti.IDProgetto=? AND Tipologia <> 0');
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $stmt->bind_result($path);
    $counter = 0;
    $r = "";
    if ($stmt->num_rows > 0) {
        $r = "<div id='carouselControls' class='carousel slide' data-ride='carousel'>
    <div class='carousel-inner'>
    <div class='carousel-item active'>
                    <img class='d-block w-100' src='$path' alt='$counter'>
                </div>";

        while ($stmt->fetch()) {
            if ($counter != 0) {
                $r = $r . "<div class='carousel-item'>
                    <img class='d-block w-100' src='$path' alt='$counter'>
                </div>";
            }
            $counter += 1;
        }

        $r = $r . "</div>
    <a class='carousel-control-prev' href='#carouselExampleControls' role='button' data-slide='prev'>
      <span class='carousel-control-prev-icon' aria-hidden='true'></span>
      <span class='sr-only'>Previous</span>
    </a>
    <a class='carousel-control-next' href='#carouselExampleControls' role='button' data-slide='next'>
      <span class='carousel-control-next-icon' aria-hidden='true'></span>
      <span class='sr-only'>Next</span>
    </a>
  </div>";
    }
    array_push($data, $r);
    $stmt->close();

    $stmt = $conn->prepare('SELECT `Descrizione`, `ImportoMin` FROM `ricompense` WHERE `IDProgetto` = ? ORDER BY `ImportoMin` ASC');
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $stmt->bind_result($rdesc, $rmin);
    $res = "";
    while ($stmt->fetch()) {
        $res = $res . " <tr><td>$rdesc</td> <td>$rmin</td><td><a class='btn btn-primary btn-sm' href='../donatori/paypal/paypal.html.php?prjname=$Nome&don=$rmin&prjid=$id'>DONA ORA</a></td></tr>";
    }

    array_push($data, $res);
    $stmt->close();
    $conn->close();
    return $data;
}
function GetProjectPrev($no_of_records_per_page, $offset, $search, $categoria)
{
    $conn = connectDB();

    $total_pages_sql = "SELECT COUNT(*) AS Pagine FROM progetti WHERE Nome LIKE ?";
    $countrows = $conn->prepare($total_pages_sql);
    $search = $search . "%";
    $countrows->bind_param("s", $search);
    $countrows->execute();
    $countrows->bind_result($total_rows);
    $countrows->fetch();
    $total_pages = ceil($total_rows / $no_of_records_per_page);
    $countrows->close();

    $cat = "";
    if ($categoria != 0)
        $cat = "AND IDTag = " . $categoria;

    $stmt = $conn->prepare("SELECT `progetti`.`IDProgetto`, `progetti`.`Nome`, `progetti`.`Descrizione`, `risorse`.`Path` FROM `progetti` 
    INNER JOIN `risorse` ON `risorse`.`IDProgetto`=`progetti`.`IDProgetto`
    WHERE `risorse`.`Tipologia`= 0 AND `progetti`.`Nome` LIKE ? $cat
    LIMIT $offset, $no_of_records_per_page");
    $stmt->bind_param("s", $search);
    $stmt->execute();
    $stmt->bind_result($id, $name, $desc, $path);

    $res = "";
    while ($stmt->fetch()) {
        $description = str_split($desc, 250)[0] . "...";
        $res = $res . "<div class='col-md-4'>
        <div class='row'>
            <div class='col-md-6'>
                <img alt='Logo' src=$path class='rounded' widht='150px' height='150px'/>
            </div>
            <div class='col-md-6'>
                <h3>
                    $name
                </h3>
            </div>
        </div>
        <div class='progress'>
            <div class='progress-bar w-75'>
            </div>
        </div>
        <div class='row'>
            <div class='col-md-12'>
                <h2>
                    Descrizione
                </h2>
                <p>
                $description
                </p>
                <p>
                    <a class='btn' href='../public/project.php?Idprj=$id'>View details»</a>
                </p>
            </div>
        </div>
    </div>";
    }
    $stmt->close();
    $conn->close();
    return [$res, $total_pages];
}

function Categorie($categoria)
{
    $conn = connectDB();
    $cat = $conn->prepare("SELECT IDTag, Ambito FROM tag");
    $cat->execute();
    $cat->bind_result($id, $nome);
    if ($categoria != 0)
        $res = "<a class='dropdown-item' href='?cat=0'>Tutto</a>";
    else
        $res = "<a class='dropdown-item active' href='?cat=0'>Tutto</a>";

    while ($cat->fetch()) {
        if ($id != $categoria)
            $res = $res . "<a class='dropdown-item' href='?cat=$id'>$nome</a>";
        else
            $res = $res . "<a class='dropdown-item active' href='?cat=$id'>$nome</a>";
    }

    $cat->close();
    $conn->close();
    return $res;
}

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
    $stmt = $mysqli->prepare("SELECT P.IDProgetto, P.Nome, P.Descrizione, T.IDTag, T.Ambito, (SELECT `Path` FROM `risorse` WHERE `Tipologia`=0 AND `IDProgetto`=P.IDProgetto) AS Logo FROM progetti AS P INNER JOIN `tag` AS T ON P.IDTag=T.IDTag WHERE P.DataF>CURRENT_DATE() ORDER BY P.DataI DESC, IDProgetto LIMIT ?");
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
    $stmt = $mysqli->prepare("SELECT P.IDProgetto, P.Nome, P.Descrizione, T.IDTag, T.Ambito, (SELECT `Path` FROM `risorse` WHERE `Tipologia`=0 AND `IDProgetto`=P.IDProgetto) AS Logo FROM progetti AS P INNER JOIN `tag` AS T ON P.IDTag=T.IDTag INNER JOIN donazioni AS D ON P.IDProgetto=D.IDProgetto WHERE P.DataF>CURRENT_DATE() GROUP BY D.`IDProgetto` ORDER BY ROUND(SUM(`Importo`),2) DESC LIMIT ?");
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
