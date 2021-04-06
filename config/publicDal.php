<?php
require 'sampleconnection.php';

function InsertDonator($mail, $usr, $psw, $name, $surn, $cdf, $addr)
{
    $conn = connectDB();
    $pass = password_hash($psw, PASSWORD_DEFAULT);
    $stmt = $conn->prepare("INSERT INTO utenti(Username, Password, `E-mail`, Indirizzo, Tipo, Nome, Cognome, CodiceFiscale) VALUES (?,?,?,?,?,?,?,?)");
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
    $stmt = $conn->prepare("INSERT INTO utenti(Username, Password, `E-mail`, Indirizzo, Tipo, CodiceFiscale, Denominazione, Telefono, PartitaIva, REA) VALUES (?,?,?,?,?,?,?,?,?,?)");
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
    $stmt = $conn->prepare("UPDATE `utenti` SET `Immagine`= ? WHERE `IDUtente` = ? ");
    $stmt->bind_param('si', $path, $id);
    $stmt->execute();
    $stmt->close();
    $conn->close();
}

function FindUser($Username)
{
    $conn = connectDB();
    $stmt = $conn->prepare("SELECT `IDUtente`,`Password`,`Tipo` FROM `utenti` WHERE `Username` = ?");
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
    $stmt = $conn->prepare("SELECT progetti.Nome, progetti.Descrizione, progetti.Obbiettivo, progetti.DataI,progetti.DataF, ricompense.ImportoMin, ricompense.Descrizione, utenti.Username, utenti.Immagine, tag.Ambito, risorse.Path
    FROM `progetti`
    INNER JOIN ricompense ON progetti.IDProgetto = ricompense.IDProgetto 
    INNER JOIN utenti ON progetti.IDOnlus = utenti.IDUtente 
    INNER JOIN tag ON progetti.IDTag= tag.IDTag 
    INNER JOIN risorse ON progetti.IDProgetto = risorse.IDProgetto
    WHERE progetti.IDProgetto = ? AND risorse.Tipologia=0");
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $stmt->bind_result($Nome, $Descrizione, $Obbiettivo, $DataI, $DataF, $ImportoMin, $Descrizione, $Username, $Immagine, $Ambito, $path);
    $stmt->fetch();
    $data = array($Nome, $Descrizione, $Obbiettivo, $DataI, $DataF, $ImportoMin, $Descrizione, $Username, $Immagine, $Ambito, $path);
    $stmt->close();
    $conn->close();
    return $data;
}
function PrintPrj($id)
{
    $data = FindProject($id);
    $title = $data[0];
    $desc = $data[1];
    $Obbiettivo = $data[2];
    $DataI = $data[3];
    $DataF = $data[4];
    $ImportoMin = $data[5];
    $Rdesc = $data[6];
    $usr = $data[7];
    $img = $data[8];
    $res=array($title,$desc,$Obbiettivo,$DataI,$DataF,$ImportoMin,$Rdesc,$Rdesc,$usr,$img);
    return $res;
}
