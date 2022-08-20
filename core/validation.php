<?php 

    function empty_val($val){
        if (empty($val)) {
            return true;
        }
        return false;
    }
    function max_len($name) {
        if (strlen($name) > 20) {
            return true;
        }
        return false;
    }
    
    function min_len($name) {
        if (strlen($name) < 3) {
            return true;
        }
        return false;
    }

    function emailValidate($email){
        if(filter_var($email, FILTER_VALIDATE_EMAIL)){
            return true;
        }
        return false;
    }

?>