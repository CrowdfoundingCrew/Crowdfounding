<?php
    require './publicDal.php';

    $user = $_POST["User"];
    $psw = $_POST["Pass"];

    $res=FindUser($user);
    if(password_verify($psw,$res[2]))
    {
        session_start();
        $_SESSION['Id']=$res[0];
        $_SESSION['User']=$user;
        $_SESSION['Pass']=$psw;
        header('Location: ../public/index.php');
    }
    else{
        echo "Wrong username or password";
        header('Location: ./login.php');
    }
?>