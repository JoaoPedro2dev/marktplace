<?php 
    include_once"../../conexao.php";

    session_start();

    if(!isset($_SESSION['admin']) || $_SESSION['admin'] !== 'sim'){
        header("Location: ../../index.php");
    }
?>