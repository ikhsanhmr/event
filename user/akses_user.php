<?php
if (session_status() == PHP_SESSION_NONE) { 
    session_start(); 
}
if(!isset($_SESSION['user'])){ 
    // header("location:javascript://history.go(-1)");
    header('Location: https://event.lokerprogrammer.com/index.php');
}
?>