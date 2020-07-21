<?php
    session_start();
    if(!isset($_SESSION["agentid"])) {
        header("Location: login.php");
        exit();
    }
?>
