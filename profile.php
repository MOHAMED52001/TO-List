<?php include('./inc/header.php'); ?>
<?php include('./inc/nav.php'); ?>
<?php include('./core/functions.php'); ?>
<?php
if(!isset($_SESSION['auth'])){
    $err[] = 'Please Login To Access This Page';
    $_SESSION['error'] = $err;
    header('Location:./login.php');
    die;
}

$account = $_SESSION['account'];
$userTasks = getTasks($account['email']);
$AllTask = getJsonData('./usertasks.json');
$removedTask = getJsonData('./db/removetasks.json');
?>
<h1 style="color:#41adff; text-align:center">Welcome <?= $account['name'] ?></h1>

<div class="card">
  <img src="<?= $account['img'] ?>" alt="<?= $account['name'] ?>" style="width:100%">
  <h1><?= $account['name'] ?></h1>
  <p class="title"><?= $account['job'] ?></p>
  <p class="title"><?= $account['major'] ?></p>
  <a target="_blank" href="<?= $account['facebook']?>">  <i class="fa-brands fa-facebook-f"></i></a>
  <a target="_blank" href="<?= $account['instagram']?>"> <i class="fa-brands fa-instagram"></i></a>
  <a target="_blank" href="<?= $account['twitter']?>">   <i class="fa-twitter fa-brands fa-twitter"></i></a>
  <a target="_blank" href="<?= $account['github']?>">   <i class="fa-brands fa-github"></i></a>
  <a target="_blank" href="<?= $account['linkedin']?>">  <i class="fa-brands fa-linkedin-in"></i></a>
  <p><button style="width: 100%;">Contact</button></p>
</div>

<section class="sec-pro">
<div class="task-card">
  <h2 style="color:#41adff;">All Added Tasks</h2>
  <p class="title"><?= $AllTask[$account['email']] ?? 0?></p>
</div>
<div class="task-card">
  <h2 style="color:#41adff;">TO-DO Tasks</h2>
  <p class="title"><?= count($userTasks) ?? 0?></p>
</div>
<div class="task-card">
  <h2 style="color:#41adff;">Done Tasks</h2>
  <p class="title"><?= $removedTask[$account['email']] ?? 0?></p>
</div>
</section>

<?php include('./inc/footer.php'); ?>