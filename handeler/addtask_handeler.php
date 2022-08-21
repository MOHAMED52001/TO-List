<?php
session_start();
include('../core/functions.php');
include('../core/validation.php');
$err = [];
$Account = $_SESSION['account'];
if (post_requestMethod($_SERVER['REQUEST_METHOD'])) {
    //Get the input Fields.
    foreach ($_POST as $key => $val) {
        $$key = clear_input($val);
    }
    //Validate the input Fields.
    if (empty($name)) {
        $err[] = 'Enter Task Name';
    }
    if (empty($des)) {
        $err[] = 'Enter Task Description';
    }
    //IF there is errors redirect to the create page.
    if (!empty($err)) {
        $_SESSION['error'] = $err;
        header('Location:../addtask.php');
        die;
    }
    // Create Array Holding Values.
    $created_date = date("m/d");
    $created_time = date("h:i:a");
    $created = $created_date . "--" . $created_time;
    $new_task = [
        "Task Name" => $name,
        "Task Description" => $des,
        "Time Created" => $created
    ];

    //Insert The New_Task To DataBase.
    $alltasks_files = '../usertasks.json';
    $userTasks = getJsonData($alltasks_files);
    $file = '../db/tasks.json';
    $old_tasks = getJsonData($file);

    if (filesize($file) == 0) {
        $first_task = array($Account['email'] => array($new_task));
        $data_to_save = $first_task;
        $counter = 1;
        $nTASKS_COUNTER = array($Account['email'] => $counter);
        $userTasks = $nTASKS_COUNTER;
    } 
    else {
        foreach ($old_tasks as $key => $task) {
            if (in_array($Account['email'],array_keys($userTasks))) {
            if ($key == $Account['email']) {
                $old_tasks[$Account['email']][] = $new_task;
                $data_to_save  = $old_tasks;
                $cTASKS_COUNTER = $userTasks[$key];
                $cTASKS_COUNTER++;
                $userTasks[$key] = $cTASKS_COUNTER;
                break;
            }
        } else {
                $old_tasks[$Account['email']][] = $new_task;
                $data_to_save  = $old_tasks;
                $counter = 1;
                $userTasks[$Account['email']] = $counter;
                break;
            }
        }
    }
    if (!file_put_contents($file, json_encode($data_to_save, JSON_PRETTY_PRINT), LOCK_EX)) {
        $err[] = 'Error saving tasks';
        $_SESSION['error'] = $err;
        header('Location:../addtask.php');
        die;
    } else {
        //redirect to Home page.
        file_put_contents($alltasks_files,json_encode($userTasks,JSON_PRETTY_PRINT),LOCK_EX);
        $_SESSION['tasks'] = $data_to_save;
        header('Location:../home.php');
        die;
    }
} else {
    $err[] = 'Unsported REQUEST_METHOD';
    $_SESSION['error'] = $err;
    header('Location:../addtask.php');
    die;
}
