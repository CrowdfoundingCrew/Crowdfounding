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

function GETOnlusProfile($id)
{
    $mysqli = connectDB();
    $stmt = $mysqli->prepare("SELECT `E-mail`, Indirizzo, CodiceFiscale, Denominazione, Telefono, PartitaIva, REA, Immagine FROM utenti WHERE IDUtente=?");
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $data = $result->fetch_array(MYSQLI_ASSOC);
    $result->free_result();
    $stmt->close();
    $mysqli->close();
    return $data;
}

function GETOnlusProgetti($id, $page)
{
    $off = (10 * (intval($page)-1));
    $mysqli = connectDB();

    $stmt = $mysqli->prepare("SELECT P.IDProgetto, P.Nome, P.Descrizione, P.Obbiettivo, P.DataI, P.DataF, T.Ambito, ROUND(SUM(D.`Importo`),2) AS Totale, COUNT(D.IDProgetto) AS Donatori FROM `donazioni` AS D RIGHT OUTER JOIN progetti AS P ON D.`IDProgetto`=P.IDProgetto INNER JOIN `tag` AS T ON P.IDTag=T.IDTag WHERE P.IDOnlus=? GROUP BY P.`IDProgetto` ORDER BY P.DataI DESC, P.DataF LIMIT 10 OFFSET ? ");

    $stmt->bind_param('ii', $id, $off);
    $stmt->execute();
    $result = $stmt->get_result();
    $data = $result->fetch_all(MYSQLI_ASSOC);
    $result->free_result();
    $stmt->close();
    $mysqli->close();
    return $data;
}

function GETCategorie()
{
    $mysqli = connectDB();
    $query = "SELECT * FROM `tag`";
    $result = $mysqli->query($query);
    $data = $result->fetch_all(MYSQLI_ASSOC);
    $result->free_result();
    $mysqli->close();
    return $data;
}

function INSERTProgetto($nome, $desc, $obiettivo, $dataF, $FKTag, $FKOnlus)
{
    $mysqli = connectDB();
    $stmt = $mysqli->prepare("INSERT INTO `progetti`(`Nome`, `Descrizione`, `Obbiettivo`, `DataI`, `DataF`, `IDTag`, `IDOnlus`) VALUES (?,?,?,CURDATE(),?,?,?)");
    $stmt->bind_param('ssisii', $nome, $desc, intval($obiettivo), $dataF, intval($FKTag), intval($FKOnlus));
    $stmt->execute();
    $result = $stmt->get_result();
    if (!$result)
        $result = $stmt->insert_id;
    $stmt->close();
    $mysqli->close();
    return $result;
}

function INSERTRisorsa($path, $tipologia, $IDProgetto)
{
    $mysqli = connectDB();
    $stmt = $mysqli->prepare("INSERT INTO `risorse`(`Path`, `Tipologia`, `IDProgetto`) VALUES (?,?,?)");
    $stmt->bind_param('sii', $path, $tipologia, $IDProgetto);
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();
    $mysqli->close();
    return $result;
}

function INSERTSocial($link, $nomesocial, $IDProgetto)
{
    $mysqli = connectDB();
    $stmt = $mysqli->prepare("INSERT INTO `social`( `Link`, `IDProgetto`, `IDTipo`) VALUES (?,?,(SELECT `IDTipo` FROM `tipo` WHERE `NomeSocial`= ?))");
    $stmt->bind_param('sis', $link, $IDProgetto, $nomesocial);
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();
    $mysqli->close();
    return $result;
}

function INSERTRicompensa($money, $desc, $IDProgetto)
{
    $mysqli = connectDB();
    $stmt = $mysqli->prepare("INSERT INTO `ricompense`(`ImportoMin`, `Descrizione`, `IDProgetto`) VALUES (?,?,?)");
    $stmt->bind_param('isi', $money, $desc, $IDProgetto);
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();
    $mysqli->close();
    return $result;
}

function GETProgetto($id)
{
    $mysqli = connectDB();
    $stmt = $mysqli->prepare("SELECT Nome, Descrizione, Obbiettivo, DataF, IDTag FROM `progetti` WHERE IDProgetto=?");
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $data = $result->fetch_array(MYSQLI_ASSOC);
    $result->free_result();
    $stmt->close();
    $mysqli->close();
    return $data;
}

function GETSocial($id, $tipo)
{
    $mysqli = connectDB();
    $stmt = $mysqli->prepare("SELECT `Link` FROM `social` INNER JOIN `tipo` ON `social`.`IDTipo`=`tipo`.`IDTipo` WHERE IDProgetto = ? AND `NomeSocial`=?");
    $stmt->bind_param('is', $id, $tipo);
    $stmt->execute();
    $result = $stmt->get_result();
    $data = $result->fetch_array(MYSQLI_ASSOC);
    $result->free_result();
    $stmt->close();
    $mysqli->close();
    if (isset($data["Link"]))
        return $data["Link"];
    else
        return "";
}

function GETRicompense($id)
{
    $mysqli = connectDB();
    $stmt = $mysqli->prepare("SELECT `ImportoMin`, `Descrizione` FROM `ricompense` WHERE `IDProgetto`=?");
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $data = $result->fetch_all(MYSQLI_ASSOC);
    $result->free_result();
    $stmt->close();
    $mysqli->close();
    return $data;
}

function UPDATEProgetto($id, $nome, $desc, $obiettivo, $dataF, $FKTag){
    $mysqli = connectDB();
    $stmt = $mysqli->prepare("UPDATE `progetti` SET `Nome`=?,`Descrizione`=?,`Obbiettivo`=?,`DataF`=?,`IDTag`=? WHERE `IDProgetto`=?");
    $stmt->bind_param('ssisii', $nome, $desc, $obiettivo, $dataF, $FKTag, $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();
    $mysqli->close();
    return $result;
}

function UPDATESocial($link, $tipo, $id){
    DELETESocial($id, $tipo);
    INSERTSocial($link, $tipo, $id);
}

function DELETESocial($id, $tipo){
    $mysqli = connectDB();
    $stmt = $mysqli->prepare("DELETE FROM `social` WHERE `IDProgetto`=? AND `IDTag`=(SELECT `IDTipo` FROM `tipo` WHERE `NomeSocial`= ?)");
    $stmt->bind_param('is', $id, $tipo);
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();
    $mysqli->close();
    return $result;
}

function UPDATEOnlusPrivate($mail, $usr, $psw, $id)
{
    $conn = connectDB();
    $pass = password_hash($psw, PASSWORD_DEFAULT);
    $stmt = $conn->prepare("UPDATE `utenti` SET `Username`=? ,`Password`=? ,`E-mail`=? WHERE `IDUtente`=?");
    $stmt->bind_param('sssi', $usr, $pass, $mail,$id);
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();
    $conn->close();
    return $result;
}

function UPDATEOnlusProfile($cdf, $addr, $den, $cell, $piva, $rea, $image, $id)
{
    $conn = connectDB();
    $stmt = $conn->prepare("UPDATE `utenti` SET `Indirizzo`=?,`CodiceFiscale`=?,`Denominazione`=?,`Telefono`=?,`PartitaIva`=?,`REA`=?,`Immagine`=? WHERE `IDUtente`=?");
    $stmt->bind_param('sssssssi', $addr, $cdf, $den, $cell, $piva, $rea, $image, $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();
    $conn->close();
    return $result;
}

function DELETEProject($id)
{
    $conn = connectDB();
    $stmt = $conn->prepare("DELETE FROM `progetti` WHERE `IDProgetto`=?");
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();
    $conn->close();
    return $result;
}

function DELETERicompense($id)
{
    $conn = connectDB();
    $stmt = $conn->prepare("DELETE FROM `ricompense` WHERE `IDProgetto`=?");
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();
    $conn->close();
    return $result;
}

function GETNumPagesProgetti($id)
{
    $mysqli = connectDB();
    $stmt = $mysqli->prepare("SELECT COUNT(*) AS C FROM `progetti` WHERE `IDOnlus`=?");
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $data = $result->fetch_array(MYSQLI_ASSOC);
    $result->free_result();
    $stmt->close();
    $mysqli->close();
    return $data['C'];
}

function GETNumPagesDonatori($id)
{
    $mysqli = connectDB();
    $stmt = $mysqli->prepare("SELECT COUNT(*) AS C FROM `progetti` WHERE `IDOnlus`=?");
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $data = $result->fetch_array(MYSQLI_ASSOC);
    $result->free_result();
    $stmt->close();
    $mysqli->close();
    return $data['C'];
}

function GETProgettoDonatori($id, $page)
{
    $off = (10 * (intval($page)-1));
    $mysqli = connectDB();

    $stmt = $mysqli->prepare("SELECT U.`IDUtente`, CONCAT(U.Nome,\" \",U.Cognome) AS Donatore, U.`E-mail`, D.`Importo`, D.`Data` FROM `donazioni` AS D INNER JOIN `utenti` AS U ON D.IDUtente=U.IDUtente WHERE `IDProgetto`=? LIMIT 10 OFFSET ? ");

    $stmt->bind_param('ii', $id, $off);
    $stmt->execute();
    $result = $stmt->get_result();
    $data = $result->fetch_all(MYSQLI_ASSOC);
    $result->free_result();
    $stmt->close();
    $mysqli->close();
    return $data;
}