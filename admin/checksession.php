<?php

session_start();
$check = isset($_SESSION['ID']) ? $_SESSION['ID'] : FALSE;

if($check and $_SESSION['Tipo']===2){ 

}else{ 
    $_SESSION['msg']="Permessi insufficienti";
    header('Location: /public'); 
}

?>