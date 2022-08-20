<?php
    session_start();
    include('../core/functions.php'); 
    include('../core/validation.php');
    $err =[];
    if (get_requestMethod($_SERVER['REQUEST_METHOD'])) {
        
        foreach ($_GET as $key => $value) {
            $$key = clear_input($value);
        }

        if(empty($email)){
            $err[] = 'Email address required';
        }
        if(empty($password)){
            $err[] = 'Password required';
        }

        if (!empty($err)){
            $_SESSION['error'] = $err;
            header('Location:../login.php');
            die;
        }

        $Accouts = getJsonData('../db/accounts.json');

        foreach($Accouts as $value){
            if ($value['email'] == $email) {
                if ($value['password'] == $password) {
                    $_SESSION['auth'] = true;
                    header("location: ../home.php");
                    die;
                }
            }
            else{
                $msg = 'Email or Password inccorect';
            }
        }

        $err[] = $msg;
        if (!empty($err)) {
            $_SESSION['error'] = $err;
            header('Location:../login.php');
            die;
        }

    }
    else{
        header("location: ../login.php");
        die;
    }








?>