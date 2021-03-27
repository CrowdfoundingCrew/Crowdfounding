<?php
require('./sampleconnection.php');

function InsertDonator($mail, $usr, $psw, $name, $surn, $cdf, $addr){
    $conn = connectDB();
    $pass = password_hash($psw,PASSWORD_DEFAULT);
    $stmt = $conn->prepare("INSERT INTO utenti(Username, Password, E-mail, Indirizzo, Tipo, Nome, Cognome, CodiceFiscale) VALUES (?,?,?,?,?,?,?,?)");
    $stmt->bind_param('ssssisss', $usr, $pass, $mail, $addr, 00, $name, $surn, $cdf);
    $stmt->execute();
    $stmt->close();
    $conn->close();
}
function InsertOnlus($mail, $usr, $psw, $cdf, $addr, $den, $cell ,$piva, $rea, $img){
    $conn = connectDB();
    $pass = password_hash($psw,PASSWORD_DEFAULT);
    $stmt = $conn->prepare("INSERT INTO utenti(Username, Password, E-mail, Indirizzo, Tipo, CodiceFiscale, Denominazione, Telefono, PartitaIva, REA, Immagine) VALUES (?,?,?,?,?,?,?,?)");
    $stmt->bind_param('ssssisssss', $usr, $pass, $mail, $addr, 01, $den, $cell ,$piva, $rea, $img);
    $stmt->execute();
    $stmt->close();
    $conn->close();
}
?>