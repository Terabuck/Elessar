<?php session_start();

    if(isset($_SESSION['dbuser'])) {
        header('location: libs/php/cerrar.php'); 
    }else{
        header('location: login.php');
    }

?>