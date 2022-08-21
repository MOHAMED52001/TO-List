<?php
session_start();
include('../core/functions.php');
include('../core/validation.php');
$err = [];
$Account = $_SESSION['account'];

$file = '../db/tasks.json';
$per_tasks = [];
$all_tasks = getJsonData($file);
$task_id = $_GET['task_id'];

foreach ($all_tasks as $key => $value) {
    if ($key == $Account['email']) {
        $per_Tasks = $value;
        break;
    }
}

array_splice($per_Tasks,$task_id,1);

$all_tasks[$Account['email']] = $per_Tasks;

if (!file_put_contents($file, json_encode($all_tasks, JSON_PRETTY_PRINT), LOCK_EX)) {
    $err[] = 'Error saving tasks';
    $_SESSION['error'] = $err;
    header('Location:../addtask.php');
    die;
} else {
    //redirect to Home page.
    $_SESSION['tasks'] = $data_to_save;
    header('Location:../managetasks.php');
    die;
}

header("location: ../home.php");
