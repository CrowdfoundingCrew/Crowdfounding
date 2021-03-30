<?php
require('./sampleconnection.php');

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
    $stmt = $conn->prepare("SELECT `IDUtente`,`Username`,`Password` FROM `utenti` WHERE `Username` = ?");
    $stmt->bind_param('s', $Username);
    $stmt->execute();
    $stmt->bind_result($id, $user, $pass);
    $stmt->fetch();
    $data = array($id, $user, $pass);
    $stmt->close();
    $conn->close();
    return $data;
}
