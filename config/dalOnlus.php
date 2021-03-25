<?php
require('config.php');

function connectDB(){
    $cfg = GetDBConfig();
    $conn = mysqli_connect($cfg['hostname'], $cfg['username'], $cfg['password'], $cfg['dbname']);
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
    return $conn;
}
function GETOnlusProfile($id){
    $mysqli=connectDB();
    $stmt=$mysqli->prepare("SELECT `E-mail`, Indirizzo, CodiceFiscale, Denominazione, Telefono, PartitaIva, REA, Immagine FROM utenti WHERE IDUtente=?");
    $stmt->bind_param('i',$id);
    $stmt->execute();
    $result=$stmt->get_result();
    $data = $result->fetch_array(MYSQLI_ASSOC);
    $result->free_result();
    $stmt->close();
    $mysqli->close();
    return $data;
}

function GETOnlusProgetti($id, $page){
    $off=(10*intval($page));
    $mysqli=connectDB();

    $stmt=$mysqli->prepare("SELECT IDProgetto, Nome, Descrizione, Obbiettivo, DataI, DataF, Ambito FROM `progetti` INNER JOIN `tag` ON progetti.IDTag=tag.IDTag WHERE progetti.IDOnlus=? ORDER BY progetti.DataI DESC, progetti.DataF LIMIT 10 OFFSET ? ");

    $stmt->bind_param('ii',$id,$off);
    $stmt->execute();
    $result=$stmt->get_result();
    $data = $result->fetch_all(MYSQLI_ASSOC);
    $result->free_result();
    $stmt->close();
    $mysqli->close();
    return $data;
}


?>