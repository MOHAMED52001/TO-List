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
    $file = '../db/tasks.json';
    $old_tasks = getJsonData($file);

    if (filesize($file) == 0) {
        $first_task = array($Account['email'] => array($new_task));
        $data_to_save = $first_task;
    } 
    else {
        foreach ($old_tasks as $key => $task) {
            if ($key == $Account['email']) {
                $old_tasks[$Account['email']][] = $new_task;
                $data_to_save  = $old_tasks;
                break;
            } else {
                $old_tasks[$Account['email']][] = $new_task;
                $data_to_save  = $old_tasks;
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
