<?php
require 'sampleconnection.php';

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
    $stmt = $conn->prepare('SELECT progetti.Nome, progetti.Descrizione, progetti.Obbiettivo, progetti.DataI, progetti.DataF, utenti.Username, utenti.Immagine, tag.Ambito, risorse.Path, utenti.Indirizzo,  utenti.Denominazione, utenti.Telefono
    FROM progetti
    INNER JOIN utenti ON progetti.IDOnlus = utenti.IDUtente 
    INNER JOIN tag ON progetti.IDTag= tag.IDTag 
    INNER JOIN risorse ON progetti.IDProgetto = risorse.IDProgetto
    WHERE progetti.IDProgetto = ? AND risorse.Tipologia=0');
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $stmt->bind_result($Nome, $Descrizione, $Obbiettivo, $DataI, $DataF, $Username, $Immagine, $Ambito, $path, $addr, $den, $tel);
    $stmt->fetch();
    $data = array($Nome, $Descrizione, $Obbiettivo, $DataI, $DataF, $Username, $Immagine, $Ambito, $path, $addr, $den, $tel);
    $stmt->close();

    $stmt = $conn->prepare('SELECT `Path` FROM `risorse` INNER JOIN progetti ON risorse.IDProgetto=progetti.IDProgetto WHERE progetti.IDProgetto=?');
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $stmt->bind_result($path);
    $counter = 0;
    $r = "<div id='carouselControls' class='carousel slide' data-ride='carousel'>
    <div class='carousel-inner'>
    <div class='carousel-item active'>
                    <img class='d-block w-100' src='$path' alt='$counter'>
                </div>";

    while ($stmt->fetch()) {
        $r = $r . "<div class='carousel-item'>
                    <img class='d-block w-100' src='$path' alt='$counter'>
                </div>";
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
    array_push($data, $r);
    $stmt->close();

    $stmt = $conn->prepare('SELECT `Descrizione`,`ImportoMin` FROM `ricompense` WHERE `IDProgetto` = ?');
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $stmt->bind_result($rdesc, $rmin);
    $res = "";
    while ($stmt->fetch()) {
        $res = $res . " <tr><td>$rdesc</td> <td>$rmin</td><td>SandBoxLink</td></tr>";
    }

    array_push($data, $res);
    $stmt->close();
    $conn->close();
    return $data;
}
