<?php
session_start();

if(isset($_GET['picturePath'])) {
    $_SESSION['picturePath'] = $_GET['picturePath'];
    header("Location: ../view/profile.php");
    exit();
}
?>