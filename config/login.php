<?php
    require './publicDal.php';

    $user = $_POST["User"];
    $psw = $_POST["Pass"];

    $res=FindUser($user);
    if(password_verify($psw,$res[1]))
    {
        session_start();
        echo 'entrato';
        $_SESSION['ID']=$res[0];
        $_SESSION['Username']=$user;
        $_SESSION['Tipo']=$res[2];
        header('Location: ../public/index.php');
    }
    else{
        echo "Wrong username or password";
        header('Location: ../public/login.php');
    }
?>