<?php
class DaneCrypt {
   
    public static function encode($password, $user) {
        $hashClave = hash('sha512', $password . strtolower($user));
        return $hashClave;
    }

}