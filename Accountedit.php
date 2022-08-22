<?php include('./inc/header.php'); ?>
<?php include('./inc/nav.php'); ?>
<?php include('./core/functions.php'); ?>

<?php
if (!isset($_SESSION['auth'])) {
    $err[] = 'Please Login To Access This Page';
    $_SESSION['error'] = $err;
    header('Location:./login.php');
    die;
} 
else {
    if (isset($_SESSION['error'])) {
        $err = $_SESSION['error'];
    }
    $account = $_SESSION['account'];
}
?>
<h1 style="color:#41adff; text-align:center">Edit</h1>
<form action="./handeler/accountedithandeler.php" method="post" enctype="multipart/form-data">
    <?php
    if (isset($err)) :
        foreach ($err as $val) : ?>
            <div>
                <div style="color: red;padding: 0.5em; margin-bottom: 0.5em;border: 1px solid red; border-radius: 0.5em; ">
                    <?= $val; ?>
                </div>
            </div>
    <?php endforeach;
    endif;
    unset($_SESSION['error']);
    ?>
    <div class="form-wrap flex-item">
        <div>
            <label for="id">Account ID</label>
            <input type="text" id="id" name="id" value="<?= $account['id'] ?>" readonly>
        </div>
        <div> 
            <label for="img">Upload Image</label>
            <input type="file" name="img"  id="img" value="<?= $account['img'] ?>" style="cursor: pointer;">
        </div>
        <div>
            <label for="name">Name</label>
            <input type="text" name="name" value="<?= $account['name'] ?>" id="name" autocomplete="off">
        </div>
        <div>
            <label for="job">Job</label>
            <input type="text" name="job" id="job" value="<?= $account['job'] ?>" autocomplete="off">
        </div>
        <div>
            <label for="major">Your Major</label>
            <input type="text" name="major" id="major" value="<?= $account['major'] ?>" autocomplete="off">
        </div>
        <div>
            <label for="email">Email</label>
            <input type="email" name="email" id="email" value="<?= $account['email'] ?>"autocomplete="off">
        </div>
        
        <div>
            <label for="">MEDIA LINKS</label>
            <input style="text-align: center;" type="text" value="<?= $account['facebook'] ?>" placeholder="facebook"   name="facebook"         autocomplete="off">
            <input style="text-align: center;" type="text" value="<?= $account['instagram'] ?>"placeholder="instagram"  name="instagram"           autocomplete="off">
            <input style="text-align: center;" type="text" value="<?= $account['twitter'] ?>"  placeholder="twitter"    name="twitter"        autocomplete="off">
            <input style="text-align: center;" type="text" value="<?= $account['github'] ?>"   placeholder="github"     name="github"          autocomplete="off">
            <input style="text-align: center;" type="text" value="<?= $account['linkedin'] ?>" placeholder="linkedin"   name="linkedin"         autocomplete="off">
        </div>

        
    </div>
    <button>Submit</button>
</form>
<?php include('./inc/footer.php'); ?>