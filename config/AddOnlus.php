<?php
require './publicDal.php';

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
    if (UPLOAD_ERR_OK === $_FILES['Logo']['error']) {
        $uploadDirPhoto = 'assets/avatar/';
        $fileNamePhoto = $result . "_" . strval(date('Y-m-d')) . "_" . basename($_FILES['Logo']['name']);
        move_uploaded_file($_FILES['Logo']['tmp_name'], "../" . $uploadDirPhoto . DIRECTORY_SEPARATOR . $fileNamePhoto);
        $profile_path = $uploadDirPhoto . DIRECTORY_SEPARATOR . $fileNamePhoto;
        InsertOnlusWithLogo($result, $profile_path);
    }
    header('Location: ../public/index.php');
} else {
    echo "<script type='text/javascript'>alert('Le password non corrispondono');</script>";
    header('Location: ../public/reg.php');
}
