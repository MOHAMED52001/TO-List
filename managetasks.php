<?php include('./inc/header.php'); ?>
<?php include('./inc/nav.php'); ?>
<?php include('./core/functions.php'); ?>
<link rel="stylesheet" href="./styles/card.css">
<?php
if (!isset($_SESSION['auth'])) {
    $err[] = 'Please Login To Access This Page';
    $_SESSION['error'] = $err;
    header('Location:./login.php');
    die;
}
?>
<h1 style="color:#41adff; margin-top: 0;margin-bottom: 1rem;text-align:center">Manage Your Tasks</h1>

<?php
$per_Tasks = [];
$file = './db/tasks.json';
$old_tasks = getJsonData($file);


foreach ($old_tasks as $key => $value) {
    if ($key == $_SESSION['account']['email']) {
        $per_Tasks = $value;
        break;
    }
}
?>
<?php
    if (empty($per_Tasks)): ?>
        <div>
        <div style="color: red;padding: 0.5em; margin-bottom: 0.5em;border: 1px solid red; border-radius: 0.5em; ">
          You Don't Have Tasks
        </div>
    </div>
<?php endif; ?>
<div class="tasks-wrapper">
    <?php foreach ($per_Tasks as $key => $tasks) : ?>
        <div class="container">
            <div class="task">
                <input class="task-item" name="task" type="checkbox" id="<?= 'item-'.$key?>" />
                <label for="<?= 'item-'.$key?>">
                    <span class="label-text"><?= $tasks['Task Name'] ?></span>
                </label>
                <div>
                    <span><a href="./edit.php?id=<?= $key ?>&name=<?= $tasks['Task Name'] ?>&des=<?= $tasks['Task Description'] ?>">Edit</a></span>
                    <span><a style="color: red; font-weight: lighter;" href="./handeler/removetask_handeler.php?task_id=<?= $key?>">Remove</a></span>
            </div>
        </div>
        <div>
            <p><?= $tasks['Task Description'] ?></p>
            <p><?= $tasks['Time Created'] ?></p>
        </div>
        <hr>
    </div>
    <?php endforeach; ?>
</div>

<?php include('./inc/footer.php'); ?>