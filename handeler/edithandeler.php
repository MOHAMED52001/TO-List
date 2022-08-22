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
    $task_id = $_POST['taskid'];
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
    $tasks = getJsonData($file);;

    foreach ($tasks as $key => $task) {
        if($key == $Account['email']){
            if(in_array($task_id, array_keys($tasks[$key]))){
                $tasks[$key][$task_id] = $new_task;
                break;
            }
            else{
                $err[] = "Task Is Not Found";
                $_SESSION['error'] = $err;
                header('Location:../home.php');
                die;
            }
        }
        else{
            $err []= "You Don't Any Tasks";
            $_SESSION['error'] = $err;
            header('Location:../list.php');
            die;
        }
    }   

    if (!file_put_contents($file, json_encode($tasks, JSON_PRETTY_PRINT), LOCK_EX)) {
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


} 
else {
    $err[] = 'Unsported REQUEST_METHOD';
    $_SESSION['error'] = $err;
    header('Location:../addtask.php');
    die;
}
