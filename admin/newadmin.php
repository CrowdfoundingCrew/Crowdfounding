<?php
include './mysql.php';

$_POST["nome"];
$_POST["cognome"];
$_POST["username"];
$_POST["email"];
$_POST["password"];
$_POST["cpassword"];

if($_POST["password"] === $_POST["cpassword"] && $_POST["password"] != "" && $_POST["username"] != "" && $_POST["nome"] != "" && $_POST["cognome"] != "" && $_POST["email"] != ""){
    NewAdmin($_POST["nome"], $_POST["cognome"], $_POST["username"], $_POST["email"], $_POST["password"]);
}
else
    header("Location: newadmin.html.php");


?>