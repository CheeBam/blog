<?php
/**
 * Created by PhpStorm.
 * User: dmitry
 * Date: 22.09.15
 * Time: 12:09
 */

namespace Framework\Security;

class Csrf
{
    public function get_token_id(){
        if(array_key_exists('token_id', $_SESSION)){
            return $_SESSION['token_id'];
        }else{
            $_SESSION['token_id'] = bin2hex(openssl_random_pseudo_bytes(2));
            return $_SESSION['token_id'];
        }
    }

    public function generateToken(){
        if(array_key_exists('token_value', $_SESSION)){
            return $_SESSION['token_value'];
        }else{
            $salt = 'qwerty';
            $secret = bin2hex(openssl_random_pseudo_bytes(4)); // 8 символов строка
            $_SESSION['token_value'] = $salt.':'.hash('sha256', $salt.':'.$secret);
            return $_SESSION['token_value'];
        }
    }
}