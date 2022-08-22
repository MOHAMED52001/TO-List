<?php include('./inc/header.php');?>
<?php include('./inc/nav.php'); ?>
<h1 style="color:#41adff; text-align:center">Login</h1>


<?php
if(isset($_SESSION['auth'])){
    header('Location:./home.php');
    die;
}
   if (!empty($_SESSION['error'])) {
    $err = $_SESSION['error'];
   
}
?>

<form action="./handeler/loginhandeler.php" method="GET">
<?php 
    if(isset($err)) : 
        foreach($err as $val) : ?>
        <div>
            <div style="color: red;padding: 0.5em; margin-bottom: 0.5em;border: 1px solid red; border-radius: 0.5em; ">
              <?= $val; ?>
            </div>
        </div>
<?php endforeach; endif;
 unset($_SESSION['error']);
 ?>
    <div class="form-wrap flex-item">
        <div>
            <label for="email">Email</label>
            <input type="email" name="email" id="email" placeholder="Enter Your Email" autocomplete="off">
        </div>
        <div>
            <label for="password">Password</label>
            <input type="password" name="password" id="password" placeholder="Enter Your Password" autocomplete="off">
        </div>
    </div>
    <label>
        <input type="checkbox" name="rememberMe"> Remember Me
    </label>
    <button>LogIn</button>
</form>
<?php include('./inc/footer.php'); ?>