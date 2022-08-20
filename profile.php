<?php include('./inc/header.php'); ?>
<?php include('./inc/nav.php'); ?>
<?php
if(!isset($_SESSION['auth'])){
    $err[] = 'Please Login To Access This Page';
    $_SESSION['error'] = $err;
    header('Location:./login.php');
    die;
}
?>
<h1 style="color:#41adff; text-align:center">Login</h1>