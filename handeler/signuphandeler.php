<?php
    session_start();
    include('../core/functions.php'); 
    include('../core/validation.php');
$err = [];
if (post_requestMethod($_SERVER['REQUEST_METHOD'])) {

    foreach ($_POST as $key => $val) {
        $$key = clear_input($val);
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
    $ID = generate_ID(substr($name, 0, 2));
    $new_account = [
        "id" => $ID,
        "name" => $name,
        "email" => $email,
        "password" => $password
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
    header('Location:../signup.php');
    die;
}
