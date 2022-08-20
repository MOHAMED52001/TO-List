<?php include('./inc/header.php');?>
<?php include('./inc/nav.php'); ?>
<?php
if(!isset($_SESSION['auth'])){
    $err[] = 'Please Login To Access This Page';
    $_SESSION['error'] = $err;
    header('Location:./login.php');
    die;
}
?>
<?php
   if (!empty($_SESSION['error'])) {
    $err = $_SESSION['error'];
   
}
?>
<h1 style="color:#41adff; text-align:center">Add Task</h1>

<form action="./handeler/addtask_handeler.php" method="POST">
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
        <label for="name">Name</label>
        <input type="text" name="name" id="name" placeholder="name"autocomplete="off">
    </div>
    <div>
        <label for="des">Description</label>
        <input type="text" name="des" id="des" placeholder="Description" autocomplete="off">
    </div>
</div>
    <button>Add</button>
</form>




<?php include('./inc/footer.php'); ?>
