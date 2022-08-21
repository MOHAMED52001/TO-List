<?php
session_start();
include('../core/functions.php');
include('../core/validation.php');
$err = [];
if (post_requestMethod($_SERVER['REQUEST_METHOD'])) {
    //Get the Data from the Form.
    foreach ($_POST as $key => $val) {
        $$key = clear_input($val);
    }
    //validate Job.
    if (empty_val($job)) {
        $err[] = 'Job is required. If you dont have a job type "Looking For Job" please';
    }
    //validate Major.
    if (empty_val($job)) {
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
    //Validate Password.
    if (max_len($password)) {
        $err[] = 'password must be at most 20 characters long';
    } elseif (min_len($password)) {
        $err[] = 'password must be at least 3 characters long';
    } elseif ($password != $password1) {
        $err[] = 'passwords not correct';
    }
    //If there is errors repeat the signup process again.
    if (!empty($err)) {
        $_SESSION['error'] = $err;
        header('Location:../signup.php');
        die;
    }
    //Save The Created Account Data.
    //check if there is img uploaded.
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
            // Validate file size
            // 1000000 bytes = 1MB
            // Upload file
            move_uploaded_file($file_tmp, $target_dir);
        } else {
            $err[] = 'Invalid IMG Format.';
        }
    }
    $ID = generate_ID(substr($name, 0, 2));
    if (empty($_FILES['img']['name'])) {
        $img_name = "./img/personaluser.png";
    } else {
        $img = $_FILES['img']['name'];
        $img_name = "./uploads/$img";
    }
   $facebook = $facebook ?? "#";
   $instagram = $instagram ?? "#";
   $linkedin = $linkedin ?? "#";
   $twitter = $twitter ?? "#";
   $github = $github ?? "#";
 
    $new_account = [
        "id" => $ID,
        "name" => $name,
        "img" => $img_name,
        "email" => $email,
        "job" => $job,
        "major" => $major,
        "password" => $password,
        "facebook" => $facebook,
        "instagram" => $instagram,
        "linkedin" => $linkedin,
        "twitter" =>  $twitter,     
        "github" =>  $github     
    ];

    //Insert the account into database.
    $file = '../db/accounts.json';
    $old_accounts = getJsonData($file);
    if (filesize($file) == 0) {
        $firstAccount = array($new_account);
        $data_to_save = $firstAccount;
    } else {
        //this will return array of errors if the account information is exists.
        $err = check_Accont_Exists($old_accounts, $new_account['name'], $new_account['email']);
        if (!empty($err)) {
            $_SESSION['error'] = $err;
            header('Location:../signup.php');
            die;
        } else {

            array_push($old_accounts, $new_account);
            $data_to_save = $old_accounts;
        }
    }

    if (!file_put_contents($file, json_encode($data_to_save, JSON_PRETTY_PRINT), LOCK_EX)) {
        $err[] = 'Error saving account';
        $_SESSION['error'] = $err;
        header('Location:../signup.php');
        die;
    } else {
        //redirect to login page.
        header('Location:../login.php');
        die;
    }
} else {
    $err[] = 'Unsported REQUEST_METHOD';
    $_SESSION['error'] = $err;
    header('Location:../signup.php');
    die;
}
