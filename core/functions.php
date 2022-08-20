<?php

    function post_requestMethod($method) {
        if($method == 'POST') return true;
        else{
            return false;
        }
    }
    function get_requestMethod($method) {
        if($method == 'GET') return true;
        else{
            return false;
        }
    }
    function clear_input($input) {
        return trim(htmlspecialchars(htmlentities($input))); 
    }
    function generate_ID($name){
        return uniqid("$name");
    }

    function getJsonData($path){
        $jsondata = file_get_contents($path);
        return json_decode($jsondata,true);
    }

    function check_Accont_Exists($ar,$name,$email){
        $err =[];
        foreach($ar as  $val){
            if($val['name'] == $name){
                $err[] = 'Name is already taken';
            }
            elseif($val['email'] == $email){
                $err[]= 'Email is already exist';
            }
        }
        return $err;
    }





?>