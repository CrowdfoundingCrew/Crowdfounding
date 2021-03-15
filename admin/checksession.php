<?php

session_start();
$check = isset($_SESSION['islogged']) ? $_SESSION['islogged'] : FALSE;

if($check and $_SESSION['ruolo']==='admin'){ 

}else{ 
    $_SESSION['msg']="Permessi insufficienti";
    header('Location: /'); 
}

?>