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
    if (empty($taskname)) {
        $err[] = 'Enter Task Name';
    }
    if (empty($des)) {
        $err[] = 'Enter Task Description';
    }

    //IF there is errors redirect to the create page.
    if (!empty($err)) {
        $_SESSION['error'] = $err;
        header('Location:../edit.php');
        die;
    }



    $file = '../db/tasks.json';
    $per_tasks = [];
    $all_tasks = getJsonData($file);
    $task_id = $_POST['taskid'];
    
    // Create Array Holding Values.
    $created_date = date("m/d");
    $created_time = date("h:i:a");
    $created = $created_date . "--" . $created_time;
    $new_task = [
        "Task Name" => $taskname,
        "Task Description" => $des,
        "Time Created" => $created
    ];
    

    //Update the task information.
    $file = '../db/tasks.json';
    $all_tasks = getJsonData($file);

    foreach ($all_tasks as $key => $task) {
        if(in_array($Account['email'], array_keys($all_tasks))){
           $per_tasks = $all_tasks[$Account['email']];
        }
    }   

    $per_tasks[$task_id] = $new_task;
    $all_tasks[$Account['email']] = $per_tasks;

    if (!file_put_contents($file, json_encode($all_tasks, JSON_PRETTY_PRINT), LOCK_EX)) {
        $err[] = 'Error saving tasks';
        $_SESSION['error'] = $err;
        header('Location:../addtask.php');
        die;
    } else {
        //redirect to Home page.
        $_SESSION['tasks'] = $tasks;
        header('Location:../home.php');
        die;
    }


} 
else {
    $err[] = 'Unsported REQUEST_METHOD';
    $_SESSION['error'] = $err;
    header('Location:../addtask.php');
    die;
}
