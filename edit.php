<?php include('./inc/header.php'); ?>
<?php include('./inc/nav.php'); ?>
<?php
if(!isset($_SESSION['auth'])){
    $err[] = 'Please Login To Access This Page';
    $_SESSION['error'] = $err;
    header('Location:./login.php');
    die;
}
else{
    if(isset($_SESSION['error'])){
    $err = $_SESSION['error'];
    }

}
?>
<h1 style="color:#41adff; text-align:center">Edit</h1>
<form action="./handeler/edithandeler.php" method="post">
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
            <label for="taskid">Task ID</label>
            <input type="text" name="taskid" value="<?=$_GET['id'] ?? 'Not Found'?>"  autocomplete="off"  readonly>
        </div>
        <div>
            <label for="taskname">New Task Name</label>
            <input type="text" name="taskname" value="<?= $_GET['name'] ?? null ?>"   placeholder="Task Name"  autocomplete="off">
        </div>
        <div>
            <label for="des">New Task Description</label>
            <input type="text" name="des"  value="<?= $_GET['des'] ?? null?>" id="des" placeholder="Task Des" autocomplete="off">
        </div>
    </div>
    <button>Submit</button>
</form>
<?php include('./inc/footer.php'); ?>