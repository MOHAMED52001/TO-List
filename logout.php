<?php 

session_start();
unset($_SESSION['error']);
unset($_SESSION['auth']);
session_destroy();
header('Location: ./login.php');
?>