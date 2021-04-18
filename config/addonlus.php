<?php
require './dalpublic.php';
define('SITE_ROOT', realpath(dirname(getcwd())));

$mail = $_POST["Email"];
$user = $_POST["Username"];
$psw = $_POST["Password"];
$psw2 = $_POST["Password2"];
$name = $_POST["Name"];
$tel = $_POST["Tel"];
$piva = $_POST["Piva"];
$cdf = $_POST["CDF"];
$rea = $_POST["REA"];
$addr =  $_POST["Address"];

if ($psw == $psw2) {
    $result = InsertOnlus($mail, $user, $psw, $cdf, $addr, $name, $tel, $piva, $rea);
    if (is_numeric($result)) {
        if (UPLOAD_ERR_OK === $_FILES['Logo']['error']) {
            $uploadDirPhoto = DIRECTORY_SEPARATOR . 'assets\avatar';
            $fileNamePhoto = $result . ".jpeg";
            move_uploaded_file($_FILES['Logo']['tmp_name'], SITE_ROOT . $uploadDirPhoto . DIRECTORY_SEPARATOR . $fileNamePhoto);
            $profile_path = $uploadDirPhoto . DIRECTORY_SEPARATOR . $fileNamePhoto;
            InsertOnlusWithLogo($result, $profile_path);
        }
    }else{
        echo "<script type='text/javascript'>alert('Errore generico');</script>";
        header('Location: ../public/reg.php');
    }
    header('Location: ../public/index.php');
} else {
    echo "<script type='text/javascript'>alert('Le password non corrispondono');</script>";
    header('Location: ../public/reg.php');
}
