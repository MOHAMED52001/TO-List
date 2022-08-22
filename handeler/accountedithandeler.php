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

    //validate job.
    if (empty_val($job)) {
        $err[] = 'Job is required. If you dont have a job type "Looking For Job" please';
    }
    //validate Major.
    if (empty_val($major)) {
        $err[] = 'Major Is Required.';
    }
    //Validate  Name.
    if (max_len($name)) {
        $err[] = 'Name must be at most 20 characters long';
    } elseif (min_len($name)) {
        $err[] = 'Name must be at least 3 characters long';
    }
    //validate  Email Address.
    if (empty_val($email)) {
        $err[] = 'Email is required';
    } elseif (!emailValidate($email)) {
        $err[] = 'Invalid Email Address';
    }
    //validate image
    $allowed_ext = array('png', 'jpg', 'jpeg');
    // Check if file was uploaded
    if (!empty($_FILES['img']['name'])) {
        $file_name = $_FILES['img']['name'];
        $file_size = $_FILES['img']['size'];
        $file_tmp = $_FILES['img']['tmp_name'];
        $target_dir = "../uploads/${file_name}";
        // Get file extension
        $file_ext = explode('.', $file_name);
        $file_ext = strtolower(end($file_ext));
        // Validate file type/extension
        if (in_array($file_ext, $allowed_ext)) {
            move_uploaded_file($file_tmp, $target_dir);
        } else {
            $err[] = 'Invalid IMG Format.';
        }
    }
    //IF there is errors redirect to the create page.
    if (!empty($err)) {
        $_SESSION['error'] = $err;
        header('Location:../Accountedit.php');
        die;
    }

    //Setup The Account New Data.
    if (empty($_FILES['img']['name'])) {
        $img_name = "./img/personaluser.png";
    } else {
        $img = $_FILES['img']['name'];
        $img_name = "./uploads/$img";
    }
    $ID = $id;
    $new_account = [
        "id" => $ID,
        "name" => $name,
        "img" => $img_name,
        "email" => $email,
        "job" => $job,
        "major" => $major,
        "password" => $Account['password'],
        "facebook" => $facebook,
        "instagram" => $instagram,
        "linkedin" => $linkedin,
        "twitter" =>  $twitter,
        "github" =>  $github
    ];

    $file = '../db/accounts.json';
    $accounts = getJsonData($file);
    foreach ($accounts as $key => $account) {
        if($account['email'] == $Account['email']){
            $accounts[$key] = $new_account;
            break;
        }
    }   

    if (!file_put_contents($file, json_encode($accounts, JSON_PRETTY_PRINT), LOCK_EX)) {
        $err[] = 'Error saving tasks';
        $_SESSION['error'] = $err;
        header('Location:../Accountedit.php');
        die;
    } else {
        //redirect to Home page.
        $_SESSION['account'] = $new_account;
        header('Location:../profile.php');
        die;
    }






    
}
else {
    $err[] = 'Unsported REQUEST_METHOD';
    $_SESSION['error'] = $err;
    header('Location:../profile.php');
    die;
}
