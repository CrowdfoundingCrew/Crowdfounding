<?php
require './publicDal.php';

$user = $_POST["Username"];
$psw = $_POST["Password"];
$psw2 = $_POST["Password2"];
$mail = $_POST["Email"];
$addr = $_POST["Address"];
$name = $_POST["Name"];
$surn = $_POST["Surn"];
$cdf = $_POST["CDF"];
if ($psw == $psw2) {
    InsertDonator($mail, $user, $psw, $name, $surn, $cdf, $addr);
    header('Location: ../public/index.php');
} else {
    echo "<script type='text/javascript'>alert('Le password non corrispondono');</script>";
    header('Location: ../public/reg.php');
}
?>