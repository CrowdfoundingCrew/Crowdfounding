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

function GETUserProfile($id)
{
    $mysqli = connectDB();
    $stmt = $mysqli->prepare("SELECT `Username`, `E-mail`, `Indirizzo`,  `Nome`, `Cognome`, `CodiceFiscale` FROM `utenti` WHERE `IDUtente`=?");
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $data = $result->fetch_array(MYSQLI_ASSOC);
    $result->free_result();
    $stmt->close();
    $mysqli->close();
    return $data;
}

function GETUserProgetti($id)
{
    $mysqli = connectDB();
    $stmt = $mysqli->prepare("SELECT P.`IDProgetto`, P.`Nome`, P.`DataI`, P.`DataF`, (SELECT `Denominazione` FROM `utenti` WHERE `IDUtente`= P.`IDOnlus`) AS OnlusName,P.`IDOnlus`, D.`Importo`, D.`Data`,(SELECT `Descrizione` FROM `ricompense` WHERE `IDProgetto`=D.`IDProgetto` AND `ImportoMin`<D.`Importo` ORDER BY `ImportoMin` DESC LIMIT 1) AS Ricompensa FROM `donazioni` AS D INNER JOIN `progetti` AS P ON D.`IDProgetto`=P.`IDProgetto` WHERE`IDUtente`= ?");
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $data = $result->fetch_all(MYSQLI_ASSOC);
    $result->free_result();
    $stmt->close();
    $mysqli->close();
    return $data;
}

function UPDATEDonatoriPrivate($email, $username,$password,$id){
    $mysqli = connectDB();
    $stmt = $mysqli->prepare("UPDATE `utenti` SET `Username`=?, `Password`=?, `E-mail`=? WHERE `IDUtente`=?");
    $stmt->bind_param('sssi', $email, $username,$password,$id);
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();
    $mysqli->close();
    return $result;
}

function UPDATEDonatoriPublic($indirizzo, $nome, $cognome, $cf, $id){
    $mysqli = connectDB();
    $stmt = $mysqli->prepare("UPDATE `utenti` SET `Indirizzo`=?,`Nome`=?,`Cognome`=?,`CodiceFiscale`=? WHERE `IDUtente`=?");
    $stmt->bind_param('ssssi', $indirizzo, $nome, $cognome, $cf, $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();
    $mysqli->close();
    return $result;
}

function DELETEDonatori($id){
    $mysqli = connectDB();
    $stmt = $mysqli->prepare("DELETE FROM `utenti` WHERE `IDUtente`=?");
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();
    $mysqli->close();
    return $result;
}


?>