<?php
if (session_status() == PHP_SESSION_NONE) { 
    session_start(); 
}
if(!isset($_SESSION['admin'])){ 
    // header("location:javascript://history.go(-1)");
    header('Location: ' . base_url() . '/index.php');
}
?>